<?php

namespace App\Http\Controllers;

use App\Models\BankTransaction;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class VPBankController extends Controller
{
    public function syncTransaction() {
        $header = [
            'Authkey' => env('VPBANK_TOKEN'),
            'Sec-Ch-Ua' => '"Not/A)Brand";v="99", "Google Chrome";v="115", "Chromium";v="115"',
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Referer' => 'https://neo.vpbank.com.vn/notification-list.html',
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 11; SM-A315G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.120 Mobile Safari/537.36'
        ];
        $endpoint = "https://neo.vpbank.com.vn/cb/odata/ns/authenticationservice/GetNonSecureNotificationShare";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $endpoint, [
            'headers' => $header,
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        $transactions = $this->normalizeData($data);
        foreach ($transactions as $transaction_id => $transaction) {
            if(BankTransaction::where('transaction_id', $transaction_id)->count() > 0)
                continue;
            $transaction_obj = new BankTransaction();
            $transaction_obj->transaction_id = $transaction_id;
            $transaction_obj->amount = $transaction['amount'];
            $transaction_obj->content = $transaction['content'];
            $transaction_obj->checked = false;
            if($transaction['type'] == "IN")
                $transaction_obj->type = 1;
            else
            $transaction_obj->type = 2;
            $transaction_obj->created_at = Carbon::parse(str_replace('/', '-', str_replace("VPB:", "", $transaction['time'])))->format('Y-m-d H:i:s');
            $transaction_obj->save();
        }
        if (debug_backtrace()[1]['class'] == "App\Http\Controllers\BankTransactionController") {
            return $transactions;
        }
        return response()->json([
            'status' => 'success',
            'data' => $transactions,
            'message' => 'Synced successfully',
        ]);

    }

    private function normalizeData($input): array
    {
        $transactions = [];
        foreach ($input['d']['results'] as $transaction) {
            $content = $transaction['Content'];
            $content = explode("|", $content);
            $amount = str_replace("VND", "", $content[2]);
            $trans_id = base64_encode($content[0] . $amount);
            $transactions[$trans_id]['time'] = $content[0];
            $transactions[$trans_id]['account'] = $content[1];
            $transactions[$trans_id]['amount'] = $amount;
            $transactions[$trans_id]['type'] = ($amount < 0) ? "OUT" : "IN";
            $transactions[$trans_id]['content'] = $content[4];
        }
        return $transactions;
    }
}
