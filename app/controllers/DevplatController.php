<?php
namespace app\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use app\models\Devplat;
use app\models\Devtrends;
use yii\web\Response;
use app\models\ValidCheck;

class DevplatController extends Controller
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
//    /**
//     * @brief 获取详细内容
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
//            $model = Researchplat::find()->where(['id' => $validator->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
//        } else {
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
//        }
//    }
    /**
     * @brief 获取类别列表
     *
     */
    public function actionGetcategory()
    {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.devplatType']);
    }
    /**
     * @brief 获取各类别的平台信息列表
     *
     */
    public function actionGetplatlist()
    {
        $validator = new ValidCheck();
        if (\Yii::$app->request->isPost) {
            $validator->load(\Yii::$app->request->post(), '');
        } else {
            $validator->load(\Yii::$app->request->get(), '');
        }
        $devplat = new Devplat();
        if ($validator->validate()) {
//            if ($validator->type == 1) {
//                $model = Devplat::find()->select(['id', 'platname', 'field', 'plattype', 'url', 'release_time'])->where(['category' => $validator->type, 'status' => \Yii::$app->params['talent.status']['published']])->orderBy('release_time DESC')->limit($validator->rn)->offset($validator->rn*$validator->pn)->all();
//            } else if ($validator->type == 2 || $validator->type == 3) {
//                $model = Devplat::find()->select(['id', 'platname', 'plevel', 'create_year', 'url', 'release_time'])->where(['category' => $validator->type, 'status' => \Yii::$app->params['talent.status']['published']])->orderBy('release_time DESC')->limit($validator->rn)->offset($validator->rn*$validator->pn)->all();
//            } else {
//                return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
//            }
//            foreach ($model as $key => $value) {
//                $model[$key]['url'] = $value['url'] . $value['id'];
//            }
            $model = $devplat->get($validator->rn, $validator->pn, $validator->type);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取各类别的平台信息列表
     *
     */
    public function actionGettrends()
    {
        $validator = new ValidCheck();
        if (\Yii::$app->request->isPost) {
            $validator->load(\Yii::$app->request->post(), '');
        } else {
            $validator->load(\Yii::$app->request->get(), '');
        }
        $devtrends = new Devtrends();
        if ($validator->validate()) {
//            $model = Devtrends::find()->select(['id', 'url', 'title', 'release_time'])->where(['status' => \Yii::$app->params['talent.status']['published']])->orderBy('release_time DESC')->limit($validator->rn)->offset($validator->rn*$validator->pn)->all();
//            foreach ($model as $key => $value) {
//                $model[$key]['url'] = $value['url'] . $value['id'];
//            }
            $model = $devtrends->get($validator->rn, $validator->pn, $validator->type);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取设备类别
     *
     */
    public function actionGetdevicetype()
    {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.devicetype']);
    }
}