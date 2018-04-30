<?php
namespace app\controllers;

use app\models\Reservation;
use app\models\Talentinfo;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\Response;
use dosamigos\qrcode\QrCode;
use app\models\Scenicorder;
use app\models\Vipchannelorder;

class QrcodeController extends ActiveController {
    public $modelClass = 'app\models\User';
    public $user = null;
    public $userId = null;
    /**
     * @return
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'except' => ['getlist', 'getcategory', 'gethonortype', 'qrcode', 'activeindex'],
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['contentNegotiator']['formats'] = '';
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }
    /**
     * @brief
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $this->user = \yii::$app->user->identity;
        $this->userId = \Yii::$app->user->id;

        return $action;
    }
    /**
     * @brief 景区签入
     */
    public function actionSceniccheckin() {
        $arrReq = $this->getRequestParams();
        if (!empty($arrReq['pid'])) {
            $talent = Talentinfo::find()->where(['user_id' => $this->userId])->one();
            if ($talent['authstatus'] != \Yii::$app->params['talent.authstatus']['authsuccess']) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['NOT_AUTH_SUCCESS'], \Yii::$app->params['ErrMsg']['NOT_AUTH_SUCCESS']);
            }
            $data = ['user_id' => $this->userId, 'scenicid' => $arrReq['pid']];
            $scenicorder = new Scenicorder();
            if ($scenicorder->load($data, '') && $scenicorder->validate()) {
                if ($scenicorder->saveData()) {
                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
                }
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
    }
    /**
     * @brief vip通道签入
     */
    public function actionVipchannelcheckin() {
        $arrReq = $this->getRequestParams();
        if (!empty($arrReq['pid'])) {
            $talent = Talentinfo::find()->where(['user_id' => $this->userId])->one();
            if ($talent['authstatus'] != \Yii::$app->params['talent.authstatus']['authsuccess']) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['NOT_AUTH_SUCCESS'], \Yii::$app->params['ErrMsg']['NOT_AUTH_SUCCESS']);
            }
            $data = ['user_id' => $this->userId, 'vipchannelid' => $arrReq['pid']];
            $vipchannelorder = new Vipchannelorder();
            if ($vipchannelorder->load($data, '') && $vipchannelorder->validate()) {
                if ($vipchannelorder->saveData()) {
                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
                }
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
    }
    /**
     * @brief 酒店签入签出
     */
    public function actionHotelcheck() {
        $arrReq = $this->getRequestParams();
        if (!empty($arrReq['pid'])) {
            $talent = Talentinfo::find()->where(['user_id' => $this->userId])->one();
            if ($talent['authstatus'] != \Yii::$app->params['talent.authstatus']['authsuccess']) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['NOT_AUTH_SUCCESS'], \Yii::$app->params['ErrMsg']['NOT_AUTH_SUCCESS']);
            }
            $hotelorder = Reservation::find()->where(['user_id' => $this->userId, 'hotelid' => $arrReq['pid']])->asArray()->all();
            if (empty($hotelorder)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
            }
            $order = array();
            foreach ($hotelorder as $key => $item) {
                if ($item['startdt'] < time() && $item['enddt'] > time()) {
                    if ($item['status'] == 1 || $item['status'] == 2) {
                        $order[] = $item;
                    }
                }
            }
            if (count($order) !== 1) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
            }
            $checkorder = $order[0];

            if ($checkorder->status == 1) {
                $res = Reservation::checkin($checkorder['id'], $this->userId);
            } else if ($checkorder->status == 2) {
                $res = Reservation::checkout($checkorder['id'], $this->userId);
            }
            if ($res) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
    }
    /**
     * @brief
     */
    public function actionQrcode()
    {
        \Yii::$app->response->format = Response::FORMAT_RAW;
        return QrCode::png('http://www.yii-china.com');    //调用二维码生成方法
    }
}