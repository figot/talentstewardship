<?php
namespace app\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use app\models\Recruit;
use app\models\Applier;
use yii\web\Response;
use app\models\ValidCheck;

class RecruitController extends Controller
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
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.recruitType']);
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
//            $model = Recruit::find()->where(['id' => $validator->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
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
        if (\Yii::$app->request->isPost) {
            $validator->load(\Yii::$app->request->post(), '');
        } else {
            $validator->load(\Yii::$app->request->get(), '');
        }
        $recruit = new Recruit();
        $applier = new Applier();
        if ($validator->validate()) {
            if ($validator->type == 2) {
                //$model = Recruit::find()->select(['id','department','title','job','welfare','company','attibute','salary', 'url', 'release_time'])->where(['status' => \Yii::$app->params['talent.status']['published']])->orderBy('release_time DESC')->limit($validator->rn)->offset($validator->rn*$validator->pn)->all();
                $model = $recruit->get($validator->rn, $validator->pn);
            } else if ($validator->type == 1) {
                $model = $applier->get($validator->rn, $validator->pn);
                //$model = Applier::find()->select(['id', 'tlevel','applier_name', 'job','company','title','content', 'portrait', 'url', 'good_fields'])->where(['status' => \Yii::$app->params['talent.status']['published']])->orderBy('release_time DESC')->limit($validator->rn)->offset($validator->rn*$validator->pn)->all();
            }
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 应聘人信息
     *
     */
    public function actionApplierinfo()
    {
        $arrReq = $this->getRequestParams();
        $applier = new Applier();
        $model = $applier->getDetail($arrReq['id']);
        if ($model) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
}