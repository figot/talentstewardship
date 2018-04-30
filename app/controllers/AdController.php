<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\Ad;
use yii\web\Response;

class AdController extends Controller
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
     * @brief 获取首页轮播图
     *
     */
    public function actionGetcrousel()
    {
        $rn = 4;
        $model = Ad::find()->select(['id','status','title','release_time','thumbnail', 'url', 'jumpurl'])->where(['status' => \Yii::$app->params['talent.status']['published']])->orderBy('release_time DESC')->limit($rn)->all();
        foreach ($model as $key => $value) {
            $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
            if (!empty($value['jumpurl'])) {
                $model[$key]['url'] = $value['jumpurl'];
            } else {
                $model[$key]['url'] = $value['url'] . $value['id'];
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
    }
}