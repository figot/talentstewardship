<?php
namespace app\controllers;

use app\models\Reservation;
use yii\web\Response;
use b\models\Hotelorder;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\Controller;
use app\models\ValidCheck;
use mrk\AliPayH5;
use app\models\Paynotifycallback;
use Opwechat\Phppayment\AppApiPay;
use Opwechat\Phppayment\Lib\WxPayUnifiedOrder;
use Opwechat\Phppayment\Lib\WxPayApi;
use yii\rest\ActiveController;

class TradeController extends ActiveController {
    public $modelClass = 'app\models\User';
    public $user = null;
    public $userId = null;
    /**
     * @brief
     *
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'except' => ['wxpaynotify'],
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
        return $behaviors;
    }
    /**
     * @brief 跳转页面，买家支付成功后跳转的页面，仅当买家支付成功后跳转一次
     */
    public function actionAlireturn() {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
    }
    /**
     * @brief 异步通知，下单成功后，支付宝服务器通知商户服务，并把这笔订单的状态通知给商户，商户根据返回的这笔订单的状态，修改网站订单的状态
     */
    public function actionAlinotify() {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
    }
    /**
     * @brief 支付宝支付
     *
     */
    public function actionAlipay() {
        \Yii::$app->response->format = Response::FORMAT_HTML;
        $client = new AliPayH5(\Yii::$app->params['alipay']);

        $data = [
            'title'=>"人才管家酒店入住支付",
            'description'=>"人才管家酒店入住支付",
            'out_trade_no' => '12345566',
            'total_amount' => 0.01
        ];
        echo $client->pay($data);
    }
    /**
     * @brief 微信支付
     *
     */
    public function actionWxpay() {
        $arrReq = $this->getRequestParams();
        $order = Reservation::find()->where(['out_trade_no' => $arrReq['out_trade_no'],])->one();
        $data = [
            'body' => "赣州市人才管家酒店房间入住付款",
            'detail' => "赣州市人才管家酒店房间入住付款",
            'out_trade_no' => $order->out_trade_no,
            'total_fee' => $order->price,
        ];
        $notify_url = 'http://47.93.42.27/app/trade/wxpaynotify';

        //统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($data['body']);
        $input->SetOut_trade_no($data['out_trade_no']);//订单号
        $input->SetTotal_fee($data['total_fee'] * 100);//金额
        $input->SetTime_start(date("YmdHis"));
        //$input->SetTime_expire(date("YmdHis", time() + 1800));
        $input->SetNotify_url($notify_url);//异步通知
        $input->SetTrade_type("APP");
        //$input->SetOpenid($openid);
        $order = WxPayApi::unifiedOrder($input);

        $apppay = new AppApiPay();
        try {
            $appData = $apppay->GetAppApiParameters($order);
        } catch (Exception $e) {
            throw  new NotFoundHttpException();
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $appData);
    }
    /**
     * @brief 微信支付异步回调
     *
     */
    public function actionWxpaynotify() {
        $notify = new Paynotifycallback();
        $notify->Handle(false);
    }
}