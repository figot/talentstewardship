<?php
namespace app\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\Collect;
use app\models\ValidCheck;

class CollectController extends ActiveController {
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
     * @brief 收藏
     */
    public function actionSet() {
        $arrReq = $this->getRequestParams();
        if (!empty($arrReq['id']) && !empty($arrReq['type'])) {
            $data = ['cid' => $arrReq['id'], 'ctype' => $arrReq['type'], 'user_id' => $this->userId];
            $collect = new Collect();
            if ($collect->load($data, '') && $collect->validate()) {
                if ($collect->saveData()) {
                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
                }
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
    }
    /**
     * @brief 取消收藏
     */
    public function actionCancell() {
        $arrReq = $this->getRequestParams();
        if (!empty($arrReq['id']) && !empty($arrReq['type'])) {
            $data = ['cid' => $arrReq['id'], 'ctype' => $arrReq['type'], 'user_id' => $this->userId];
            $collect = new Collect();
            if ($collect->load($data, '') && $collect->validate()) {
                if ($collect->Cancell()) {
                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
                }
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
    }
    /**
     * @brief 我的收藏
     */
    public function actionGet() {
        $arrReq = $this->getRequestParams();
        $validator = new ValidCheck();
        $collect = new Collect();
        if ($validator->load($arrReq, '') && $validator->validate()) {
            $model = $collect->get($this->userId, $validator->rn, $validator->pn);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
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