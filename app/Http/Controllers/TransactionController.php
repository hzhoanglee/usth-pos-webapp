<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Psy\Util\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransactionController extends Controller
{
    public function checkCall(Request $request) {
        $needle = $request->needle;
        if ($needle == null || $needle == "" || $needle == "undefined" || $needle == 0)
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Needle is required',
            ]);
        try {
            $match = false;
            (new VPBankController)->syncTransaction();
            $data = BankTransaction::where('checked', false)->where('content', 'like', "%".$needle."%")->get();
            $qr = \App\Models\QrCode::where('code', $needle)->first();
            foreach($data as $transaction) {
                if($qr->amount <= $transaction->amount) {
                    $match = true;
                    $transaction->checked = true;
                    $transaction->save();
                    $qr->transaction_id = $transaction->id;
                    $qr->checked = true;
                    $qr->updated_at = Carbon::now();
                    $qr->save();
                }
            }
            if($data->count() > 0)
                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'message' => 'Here we go',
                    'match' => $match,
                ]);
            else
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'Do not found any unchecked transaction',
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'data' => [],
                'message' => $e->getMessage(),
            ]);
        }

    }

    public function generateQR(Request $request){
        $amount = $request->amount;
        if ($amount <= 0) {
            return response()->json([
                'success' => false,
                'uuid' => null,
                'message' => 'Số tiền không hợp lệ'
            ]);
        }
        $qr = new \App\Models\QrCode();
        $qr->amount = $amount;
        $qr->code = \Illuminate\Support\Str::random(6);
        $qr->uuid = \Illuminate\Support\Str::uuid();
        $qr->content = "";
        $qr->save();
        return response()->json([
            'success' => true,
            'uuid' => $qr->uuid,
            'message' => 'Tạo mã QR thành công'
        ]);
    }

    public function displayQR(Request $request){
        $qr = \App\Models\QrCode::where('uuid', $request->uuid)->first();
        $bank_id = $request->bank_id;
        $bank = BankAccount::find($bank_id);
        if(!$bank) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Không tìm thấy ngân hàng'
            ]);
        }
        $bankCode = $bank->bank;
        $bankAccount = $bank->account;
        $message = $qr->code;
        $hash = $this->generate_string_hash($bankCode, $bankAccount, $qr->amount, $message);
        $qrCode = QrCode::style('round')->size(300)->generate($hash);
        if ($qr == null) {
            return response("Không tìm thấy mã QR", 404);
        }
        return $qrCode;
    }

    public static function genQRUUID($amount) {
        $qr = new \App\Models\QrCode();
        $qr->amount = $amount;
        $qr->code = \Illuminate\Support\Str::random(6);
        $qr->uuid = \Illuminate\Support\Str::uuid();
        $qr->content = "";
        $qr->save();
        return $qr;
    }

    public static function dispQr($amount, $bank_id) {
        if($amount <= 0) {
            return false;
        }
        if(!$bank_id) {
            return false;
        }
        $bank = BankAccount::find($bank_id);
        if(!$bank) {
            return false;
        }
        $qr = TransactionController::genQRUUID($amount);
        $bankCode = $bank->bank;
        $bankAccount = $bank->bank_number;
        $message = $qr->code;
        $hash = (new TransactionController)->generate_string_hash($bankCode, $bankAccount, $qr->amount, $message);
        $qrCode = QrCode::style('round')->size(300)->generate($hash);
        return $qrCode;
    }


    private function generateCheckSum($text) {
        $crc = 0xFFFF;          // initial value
        $polynomial = 0x1021;   // 0001 0000 0010 0001  (0, 5, 12)
        $bytes = str_split($text);
        foreach ($bytes as $b) {
            $b = ord($b); // Get the ASCII value of the character
            for ($i = 0; $i < 8; $i++) {
                $bit = (($b >> (7 - $i)) & 1) == 1;
                $c15 = (($crc >> 15) & 1) == 1;
                $crc <<= 1;
                if ($c15 ^ $bit) {
                    $crc ^= $polynomial;
                }
            }
        }
        return dechex($crc & 0xFFFF);
    }

    private function generate_string_hash($bankCode, $bankAccount, $amount, $message): string
    {

        $bankIdByCode = array(
            "TPB" => "970423",
            "VPB" => "970432"
        );

        $bankId = $bankIdByCode[$bankCode];
        $part12Builder = "00" . sprintf("%02d", strlen($bankId)) . $bankId . "01" . sprintf("%02d", strlen($bankAccount)) . $bankAccount;
        $part11Builder = "0010A000000727" . "01" . sprintf("%02d", strlen($part12Builder)) . $part12Builder . "0208QRIBFTTA";
        $part1Builder = "38" . sprintf("%02d", strlen($part11Builder)) . $part11Builder;
        $part21Builder = "08" . sprintf("%02d", strlen($message)) . $message;
        $part2 = "5303704" . "54" . sprintf("%02d", strlen($amount)) . $amount . "5802VN" . "62" . sprintf("%02d", strlen($part21Builder)) . $part21Builder;
        $builder = "000201" . "010212" . $part1Builder . $part2 . "6304";
        return $builder . strtoupper($this->generateCheckSum($builder));
    }

}
