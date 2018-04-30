<?php
namespace app\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\Response;
use app\models\ValidCheck;
use app\models\Message;

class MessageController extends Controller
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
     *
     */
    public function actionGetlist()
    {
        $arrReq = $this->getRequestParams();
        $validator = new ValidCheck();
        if (\Yii::$app->request->isPost) {
            $validator->load(\Yii::$app->request->post(), '');
        } else {
            $validator->load(\Yii::$app->request->get(), '');
        }
        $message = new Message();
        if ($validator->validate()) {
            $model = $message->get($validator->rn, $validator->pn, $this->userId);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
}