# alipay-h5

### H5 调起 支付宝钱包支付

```php
$config = array (
    //应用ID,您的APPID。
    'app_id' => "20xxxxxxxx69",

    //商户私钥，您的原始格式私钥,一行字符串
    'merchant_private_key' => "xxxxxx",

    //商户应用公钥,一行字符串
    'merchant_public_key' => "xxxxxxxx",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "xxxxxx",


    //编码格式只支持GBK。
    'charset' => "UTF-8",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

    //签名方式
    'sign_type'=>"RSA2",

    'return_url' => "xx",

    'notify_url' => "xx",
);
require "./vendor/autoload.php";

use mrk\AliPayH5;

$client = new AliPayH5($config);

$data = [
    'title'=>"test",
    'description'=>"test 123",
    'out_trade_no' => '12345566',
    'total_amount' => 0.01
];
$client->pay($data);
```
### 回调

```php
$arr = $_POST
$client = new AliPayH5($config);
$result = $client->check($arr);
if($result){
//业务

}else{
//业务
}
```