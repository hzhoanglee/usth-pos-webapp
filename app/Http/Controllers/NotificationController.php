<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Zalo\Builder\MessageBuilder;
use Zalo\Common\TransactionTemplateType;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;

class NotificationController extends Controller
{
    public function sendZalo() {
        $config = array(
            'app_id' => '3163462875972056510',
            'app_secret' => 'yBLU7e88GcCGw4dTBrP6'
        );
        try {
            $zalo = new Zalo($config);
        } catch (\Throwable $th) {
            dd($th);
        }
        if(!Cache::get('zalo_token')) {
            $helper = $zalo->getRedirectLoginHelper();
            $codeVerifier = $this->genCodeVerifier();
            $codeChallenge = $this->genCodeChallenge($codeVerifier);

            if(!isset($_GET['code'])) {
                return redirect()->away($helper->getLoginUrl(route('notify.zalo.test'), $codeChallenge, 'state'));
            }
            $zaloToken = $helper->getZaloTokenByOA($codeVerifier); // get zalo token
            $accessToken = $zaloToken->getAccessToken();
            Cache::put('zalo_token', $accessToken, 60 * 24 * 30);
        }
        $accessToken = Cache::get('zalo_token');


        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_TRANSACTION);
        $msgBuilder->withPhoneNumber('0886662806');

        $msgBuilder->withTemplateType(TransactionTemplateType::TRANSACTION_ORDER);
        $msgBuilder->withLanguage("VI");

        $headerElement = array(
            'content' => 'Trạng thái đơn hàng',
            'align' => 'left',
            'type' => 'header'
        );
        $msgBuilder->addElement($headerElement);

        $text1Element = array(
            'align' => 'left',
            'content' => '• Cảm ơn bạn đã mua hàng tại cửa hàng.<br>• Thông tin đơn hàng của bạn như sau:',
            'type' => 'text'
        );
        $msgBuilder->addElement($text1Element);

        $tableContent1 = array(
            'key' => 'Mã khách hàng',
            'value' => 'F-01332973223'
        );
        $tableContent2 = array(
            'key' => 'Trạng thái',
            'value' => 'Đang giao',
            'style' => 'yellow',
        );
        $tableContent3 = array(
            'key' => 'Giá tiền',
            'value' => '250,000đ'
        );
        $tableElement = array(
            'content' => array($tableContent1, $tableContent2, $tableContent3),
            'type' => 'table'
        );
        $msgBuilder->addElement($tableElement);

        $text2Element = array(
            'content' => 'Lưu ý điện thoại. Xin cảm ơn!',
            'align' => 'center',
            'type' => 'text'

        );
        $msgBuilder->addElement($text2Element);

        $actionOpenUrl = $msgBuilder->buildActionOpenURL('https://oa.zalo.me/home');
        $msgBuilder->addButton('Kiểm tra lộ trình - default icon', '', $actionOpenUrl);

        $actionQueryShow = $msgBuilder->buildActionQueryShow('Xem lại giỏ hàng');
        $msgBuilder->addButton('Xem lại giỏ hàng', 'wZ753VDsR4xWEC89zNTsNkGZr1xsPs19vZF22VHtTbxZ8zG9g24u3FXjZrQvQNH2wMl1MhbwT5_oOvX5_szXLB8tZq--TY0Dhp61JRfsAWglCej8ltmg3xC_rqsWAdjRkctG5lXzAGVlQe9BhZ9mJcSYVIDsc7MoPMnQ', $actionQueryShow);

        $actionOpenPhone = $msgBuilder->buildActionOpenPhone('84123456789');
        $msgBuilder->addButton('Liên hệ tổng đài', 'gNf2KPUOTG-ZSqLJaPTl6QTcKqIIXtaEfNP5Kv2NRncWPbDJpC4XIxie20pTYMq5gYv60DsQRHYn9XyVcuzu4_5o21NQbZbCxd087DcJFq7bTmeUq9qwGVie2ahEpZuLg2KDJfJ0Q12c85jAczqtKcSYVGJJ1cZMYtKR', $actionOpenPhone);

        $msgTransaction = $msgBuilder->build();
        $msgTransaction['mode'] = 'development';

        $response = $zalo->post('https://business.openapi.zalo.me/message/template', $accessToken, $msgTransaction);
        $result = $response->getDecodedBody();
        dd($result);
    }

    public static function genCodeVerifier(): string
    {
        $random = bin2hex(openssl_random_pseudo_bytes(32));
        return self::base64url_encode(pack('H*', $random));
    }

    public static function genCodeChallenge($codeVerifier): string
    {
        if (!isset($codeVerifier)) {
            return '';
        }

        return self::base64url_encode(pack('H*', hash('sha256', $codeVerifier)));
    }

    private static function base64url_encode($plainText): string
    {
        $base64 = base64_encode($plainText);
        $base64 = trim($base64, "=");
        return strtr($base64, '+/', '-_');
    }
}
