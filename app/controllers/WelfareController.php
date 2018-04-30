<?php
namespace app\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\Welfare;
use app\models\TalentCategory;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\helpers\ArrayHelper;

class WelfareController extends ActiveController {
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
            'except' => ['getenjoylevel', 'getapplylevel', 'gettalentlevel'],
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
        $welfare = new Welfare();
        $welfare->load($arrReq, '');
        if ($welfare->validate()) {
            if ($welfare->saveData($this->userId)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取福利待遇信息
     */
    public function actionGet() {
        $arrReq = $this->getRequestParams();
        $talentinfo = new Welfare();
        $talentinfo->load($arrReq, '');
        $model = $talentinfo->getData($this->userId);
        if ($model) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取福利待遇享受级别信息
     */
    public function actionGetenjoylevel() {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], array_values(\Yii::$app->params['talent.welfarelevel']));
    }
    /**
     * @brief 获取申报福利待遇级别信息
     */
    public function actionGetapplylevel() {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], array_values(\Yii::$app->params['talent.applywelfarelevel']));
    }
    /**
     * @brief 获取人才级别信息
     */
    public function actionGettalentlevel() {
        $level = TalentCategory::find()->where(['status' => 2])->select(['talentlevel'])->asArray()->all();
        foreach ($level as $key => $value) {
            $levelconf[] = $value['talentlevel'];
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], array_values($levelconf));
    }
}