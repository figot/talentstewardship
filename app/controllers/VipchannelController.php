<?php
namespace app\controllers;

use app\models\ValidCheck;
use app\models\Vipchannel;
use yii\rest\ActiveController;
use yii\web\Response;

class VipchannelController extends ActiveController {
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
     * @brief 获取vip通道列表
     */
    public function actionGetlist() {
        $arrReq = $this->getRequestParams();
        $validator = new ValidCheck();
        $vipchannel = new Vipchannel();
        $vipchannel->load($arrReq, '');
        $validator->load($arrReq, '');
        if ($vipchannel->validate() && $validator->validate()) {
            $model = $vipchannel->get($validator->rn, $validator->pn, $arrReq);
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