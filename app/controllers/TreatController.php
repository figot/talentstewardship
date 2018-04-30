<?php
namespace app\controllers;

use app\models\Treatapply;
use app\models\TreatApplyFiles;
use app\models\Treatment;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\Welfare;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use app\models\ValidCheck;
use app\models\Talentinfo;

class TreatController extends ActiveController {
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
            'except' => [''],
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
     * @brief 设置待遇享受信息
     */
    public function actionSet() {
        $arrReq = $this->getRequestParams();
        $talent = Talentinfo::findOne(['user_id' => $this->userId]);
        if (empty($talent)) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['NOT_TALENT_INFO'], \Yii::$app->params['ErrMsg']['NOT_TALENT_INFO']);
        }
        $apply = new Treatapply();
        $apply->load($arrReq, '');
        if ($apply->validate()) {
            $applyid = $apply->saveData($this->userId);
            if (!empty($applyid)) {
                $applyfiles = new TreatApplyFiles();
                $applyfiles->saveImgs($applyid, $this->userId, $arrReq['uploads']);
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取专属待遇
     */
    public function actionGetlist() {
        $arrReq = $this->getRequestParams();
        $validator = new ValidCheck();
        $treat = new Treatment();

        if ($validator->load($arrReq, '') && $validator->validate()) {
            $model = $treat->get($validator->rn, $validator->pn, $this->userId);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
}