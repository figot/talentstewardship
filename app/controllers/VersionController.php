<?php
namespace app\controllers;

use app\models\Version;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\Response;
use app\models\SmsCache;

class VersionController extends Controller
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
    public function actionGetlatest()
    {
        $latestversion = Version::find()->select(['version', 'url', 'ostype', 'updated_at'])->one();
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $latestversion);

    }
}