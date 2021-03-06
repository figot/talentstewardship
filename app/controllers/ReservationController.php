<?php
namespace app\controllers;

use app\models\Reservation;
use app\models\Talentinfo;
use b\models\Hotel;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\TalentCategory;

class ReservationController extends ActiveController
{
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
            'except' => [],
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
     * @brief 提交订单
     */
    public function actionCommit()
    {
        $arrReq = $this->getRequestParams();
        $reserve = new Reservation();
        $reserve->load($arrReq, '');
        $talent = Talentinfo::find()->where(['user_id' => $this->userId])->one();
        $edu = array();
        $pretalent = TalentCategory::find(['id', 'talentlevel'])->asArray()->all();
        foreach ($pretalent as $v) {
            $edu[$v['id']] = $v['talentlevel'];
        }
        if ($talent['authstatus'] != \Yii::$app->params['talent.authstatus']['authsuccess']) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['NOT_AUTH_SUCCESS'], \Yii::$app->params['ErrMsg']['NOT_AUTH_SUCCESS']);
        }
        $hotel = Hotel::find()->where(['id' => $arrReq['hotelid']])->one();
        if (!isset($edu[$talent['category']])) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['TALENT_LEVEL_NOT_MATCH_HOTEL'], \Yii::$app->params['ErrMsg']['TALENT_LEVEL_NOT_MATCH_HOTEL']);
        }
        if (strpos($hotel['suitper'], $edu[$talent['category']]) === false) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['TALENT_LEVEL_NOT_MATCH_HOTEL'], \Yii::$app->params['ErrMsg']['TALENT_LEVEL_NOT_MATCH_HOTEL']);
        }
        if ($reserve->validate()) {
            $model = $reserve->saveData($this->userId);
            if ($model != false) {
                $arrRes = $model->attributes;
                $arrRes['total_fee'] = $arrRes['price'];
                $arrRes['isfree'] = $arrRes['ischkinbeforedate'];
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $arrRes);
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);

    }
    /**
     * @brief 取消订单
     */
    public function actionCancell()
    {
        $arrReq = $this->getRequestParams();
        $reserve = new Reservation();
        $model = $reserve->cancell($arrReq['id'], $this->userId);
        if ($model) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);

    }
}