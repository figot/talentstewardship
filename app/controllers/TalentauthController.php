<?php
namespace app\controllers;

use app\models\TalentCategory;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\Talentfiles;
use app\models\Talentapply;
use app\models\TalentApplyfiles;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\ValidCheck;
use app\models\Talentinfo;
use yii\helpers\ArrayHelper;

class TalentauthController extends ActiveController {
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
            'except' => ['getdepart'],
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
     * @brief 提交
     */
    public function actionSet() {
        $arrReq = $this->getRequestParams();
        $talent = Talentinfo::findOne(['user_id' => $this->userId]);
        if (empty($talent)) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['NOT_TALENT_INFO'], \Yii::$app->params['ErrMsg']['NOT_TALENT_INFO']);
        }
        $arrReq['talentcategoryid'] = $arrReq['talentauthid'];
        $talent = new Talentapply();
        if (isset($arrReq['id'])) {
            $id = intval($arrReq['id']);
        } else {
            $id = null;
        }
        $talent->load($arrReq, '');

        if ($talent->validate()) {
            $applyid = $talent->saveData($this->userId);
            if (isset($applyid)) {
                if (is_array($arrReq['uploads'])) {
                    $applyfiles = new TalentApplyfiles();
                    $applyfiles->saveImgs($arrReq['uploads'], $applyid);
                }
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
    }
    /**
     * @brief 获取人才认证列表
     */
    public function actionGetlist() {
        $arrReq = $this->getRequestParams();
        $validator = new ValidCheck();
        $talent = new TalentCategory();

        if ($validator->load($arrReq, '') && $validator->validate()) {
            $model = $talent->get($validator->rn, $validator->pn, $this->userId);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
}