<?php
namespace app\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use app\models\News;
use yii\web\Response;
use app\models\ValidCheck;
use app\models\User;

class NewsController extends Controller
{
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
            'except' => ['getlistbytype', 'getcategory', 'getlist'],
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['contentNegotiator']['formats'] = '';
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }
    /**
     * @brief 获取类别列表
     *
     */
    public function actionGetcategory()
    {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.newsType']);
    }
    /**
     * @brief
     *
     */
    public function actionGetlist()
    {
        $arrReq = $this->getRequestParams();
        $validator = new ValidCheck();
        $validator->load($arrReq, '');
        $this->user = User::findOne(['access_token' => $arrReq['access_token'],]);
        if (!empty($this->user)) {
            $this->userId = $this->user->id;
        }
        $news = new News();
        if ($validator->validate()) {
            $model = $news->get($validator->rn, $validator->pn, $this->userId);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief
     *
     */
    public function actionGetlistbytype()
    {
        $arrReq = $this->getRequestParams();
        $validator = new ValidCheck();
        $validator->load($arrReq, '');
        $this->user = User::findOne(['access_token' => $arrReq['access_token'],]);
        if (!empty($this->user)) {
            $this->userId = $this->user->id;
        }

        $news = new News();
        if ($validator->validate()) {
            $model = $news->get($validator->rn, $validator->pn, $this->userId, $validator->type);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
}