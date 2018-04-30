<?php
namespace app\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use app\models\Policy;
use yii\web\Response;
use app\models\ValidCheck;
use app\models\User;

class PolicyController extends Controller
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
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.policyType']);
    }
//    /**
//     * @brief
//     *
//     */
//    public function actionGetcontent()
//    {
//        $validator = new ValidCheck();
//        if (\Yii::$app->request->isPost) {
//            $validator->load(\Yii::$app->request->post(), '');
//        } else {
//            $validator->load(\Yii::$app->request->get(), '');
//        }
//        if ($validator->validate()) {
//            $model = Policy::find()->where(['id' => $validator->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
//        } else {
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
//        }
//    }
    /**
     * @brief
     *
     */
    public function actionGetlist()
    {
        $validator = new ValidCheck();
        $arrReq = $this->getRequestParams();
        $validator->load($arrReq, '');
        $policy = new Policy();
        if ($validator->validate()) {
//            $model = Policy::find()->select(['id','department','url', 'policytype','status','title','url', 'release_time','thumbnail','read_count'])->where(['status' => \Yii::$app->params['talent.status']['published']])->orderBy('release_time DESC')->limit($validator->rn)->offset($validator->rn*$validator->pn)->all();
//            foreach ($model as $key => $value) {
//                $model[$key]['url'] = $value['url'] . $value['id'];
//                if (!empty($value['thumbnail'])) {
//                    $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
//                }
//            }
            $model = $policy->get($validator->rn, $validator->pn, $this->userId);
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
        $validator = new ValidCheck();
        $arrReq = $this->getRequestParams();
        $validator->load($arrReq, '');
        $this->user = User::findOne(['access_token' => $arrReq['access_token'],]);
        if (!empty($this->user)) {
            $this->userId = $this->user->id;
        }
        $policy = new Policy();
        if ($validator->validate()) {
            $model = $policy->get($validator->rn, $validator->pn, $this->userId, $validator->type);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
}