<?php
namespace app\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use app\models\Activity;
use yii\web\Response;
use app\models\ValidCheck;

class ActController extends Controller
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
     * @brief 获取交流培训详细内容
     *
     */
    public function actionGetcontent()
    {
        $validator = new ValidCheck();
        if (\Yii::$app->request->isPost) {
            $validator->load(\Yii::$app->request->post(), '');
        } else {
            $validator->load(\Yii::$app->request->get(), '');
        }
        if ($validator->validate()) {
            $model = Activity::find()->where(['id' => $validator->id, 'status' => \Yii::$app->params['talent.trainType']['published']])->one();
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取类别列表
     *
     */
    public function actionGetcategory()
    {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.trainType']);
    }
    /**
     * @brief 获取各类别的交流培训列表
     *
     */
    public function actionGetactlist()
    {
        $validator = new ValidCheck();
        if (\Yii::$app->request->isPost) {
            $validator->load(\Yii::$app->request->post(), '');
        } else {
            $validator->load(\Yii::$app->request->get(), '');
        }
        $act = new Activity();
        if ($validator->validate()) {
//            $model = Activity::find()->select(['id', 'department', 'title', 'url', 'activity_time', 'activity_pos', 'user_cnt', 'thumbnail', 'read_count', 'release_time'])->where(['acttype' => $validator->type, 'status' => \Yii::$app->params['talent.status']['published']])->orderBy('release_time DESC')->limit($validator->rn)->offset($validator->rn*$validator->pn)->all();
//            foreach ($model as $key => $value) {
//                if (!empty($value['thumbnail'])) {
//                    $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
//                }
//                $model[$key]['url'] = $value['url'] . $value['id'];
//            }
            $model = $act->get($validator->rn, $validator->pn, $validator->type);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
}