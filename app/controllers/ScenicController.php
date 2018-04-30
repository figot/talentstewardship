<?php
namespace app\controllers;

use app\models\Scenic;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\ValidCheck;

class ScenicController extends ActiveController {
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
        $behaviors['contentNegotiator']['formats'] = '';
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }
    /**
     * @brief 获取景区列表
     */
    public function actionGetlist() {
        $arrReq = $this->getRequestParams();
        $validator = new ValidCheck();
        $scenic = new Scenic();
        $scenic->load($arrReq, '');
        if ($validator->load($arrReq, '') && $validator->validate()) {
            if (empty($arrReq['latitude']) || empty($arrReq['longitude'])) {
                $model = $scenic->get($validator->rn, $validator->pn, $arrReq);
            }
//            foreach ($model['list'] as $key => $value) {
//                $model['list'][$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
//                $model['list'][$key]['distance'] = intval($key) + 0.1;
//                $model['list'][$key]['url'] = $value['url'] . $value['id'];
//            }
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
}