<?php
namespace Opwechat\Phppayment;

use Opwechat\Phppayment\Lib\WxPayApi;
use Opwechat\Phppayment\Lib\WxPayException;
use Opwechat\Phppayment\Lib\WxPayAppApiPay;
use Opwechat\Phppayment\WxPayConfig;
use yii\base\Exception;

class AppApiPay
{

    private static  function getConfig()
    {
        return WxPayConfig::getInstance();
    }


    public function GetAppApiParameters($UnifiedOrderResult)
    {
        if(!array_key_exists("appid", $UnifiedOrderResult)
            || !array_key_exists("prepay_id", $UnifiedOrderResult)
            || $UnifiedOrderResult['prepay_id'] == "")
        {
            throw new Exception("参数错误");
        }
        $appapi = new WxPayAppApiPay();
        $appapi->SetAppid($UnifiedOrderResult["appid"]);
        $appapi->SetPartnerId($UnifiedOrderResult["mch_id"]);
        $appapi->SetPrepayId($UnifiedOrderResult["prepay_id"]);
        $appapi->SetPackage("Sign=WXPay");
        $appapi->SetNonceStr(WxPayApi::getNonceStr());
        $timeStamp = time();
        $appapi->SetTimeStamp($timeStamp);

        $appapi->SetSign($appapi->MakeSign());
        $parameters = $appapi->GetValues();
        return $parameters;
    }


    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
}