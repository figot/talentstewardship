<?php
namespace app\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use app\models\Cooperation;
use yii\web\Response;
use app\models\ValidCheck;

class CoopController extends Controller
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
     * @brief 获取类别列表
     *
     */
    public function actionGetcategory()
    {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.coopType']);
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
//            $model = Cooperation::find('title', 'content', 'release_time')->where(['id' => $validator->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
//        } else {
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
//        }
//    }
    /**
     * @brief 获取项目合作列表
     *
     */
    public function actionGetlist()
    {
        $validator = new ValidCheck();
        if (\Yii::$app->request->isPost) {
            $validator->load(\Yii::$app->request->post(), '');
        } else {
            $validator->load(\Yii::$app->request->get(), '');
        }
        $coop = new Cooperation();
        if ($validator->validate()) {
//            $model = Cooperation::find()->select(['id','ctype', 'url', 'title', 'release_time'])->where(['status' => \Yii::$app->params['talent.status']['published']])->orderBy('release_time DESC')->limit($validator->rn)->offset($validator->rn*$validator->pn)->all();
//            foreach ($model as $key => $value) {
//                $model[$key]['url'] = $value['url'] . $value['id'];
//            }
            $model = $coop->get($validator->rn, $validator->pn);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief  发布项目合作信息
     *
     */
    public function actionPublish()
    {
        $coop = new Cooperation();
        if (\Yii::$app->request->isPost) {
            $coop->load(\Yii::$app->request->post(), '');
        } else {
            $coop->load(\Yii::$app->request->get(), '');
        }
        if ($coop->validate() && $coop->save()) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 根据类型获取项目合作信息
     *
     */
    public function actionGetlistbytype()
    {
        $validator = new ValidCheck();
        if (\Yii::$app->request->isPost) {
            $validator->load(\Yii::$app->request->post(), '');
        } else {
            $validator->load(\Yii::$app->request->get(), '');
        }
        $coop = new Cooperation();
        if ($validator->validate()) {
//            $model = Cooperation::find()->select(['id', 'title', 'url', 'release_time'])->where(['ctype' => $validator->type, 'status' => \Yii::$app->params['talent.status']['published']])->orderBy('release_time DESC')->limit($validator->rn)->offset($validator->rn*$validator->pn)->all();
//            foreach ($model as $key => $value) {
//                $model[$key]['url'] = $value['url'] . $value['id'];
//            }
            $model = $coop->get($validator->rn, $validator->pn, $validator->type);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
}