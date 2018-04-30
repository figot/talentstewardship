<?php
namespace app\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\Response;
use app\models\SmsCache;

class TestController extends Controller
{
    /**
     * @brief
     *
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = '';
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * @brief
     *
     */
    public function actionGet()
    {
        return md5('/Applications/XAMPP/xamppfiles/temp/phpfUuwMg');
        //return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
        $redis = \Yii::$app->redis;
        $res = $redis->set('test','test redis string');

        $model = new SmsCache();
        $model->load(\Yii::$app->request->post());
        if ($model->validate()) {
            $model->getCache();
        }

        return [
            'errno' => 0,
            'errmsg' => '',
            'data' => array(
                $model->signupCache,
                $model->mobile,
            ),
            'post' => \Yii::$app->request->post('mobile'),
            'get' => $redis->get('test'),
            'req' => \Yii::$app->getRequest()->getBodyParams(),
            'res' => $res,
        ];
    }
}