<?php
namespace b\controllers;

use b\models\Welfare;
use b\models\Welfaretemplate;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Welfareapply;
use b\models\Welfareapplyfiles;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
/**
 * 专属待遇模板列表
 */
class WelfaretemplateController extends Controller
{
    public function init()
    {
        /* 判断是否登录 */
        if (\Yii::$app->user->getIsGuest()) {
            $this->redirect(Url::toRoute(['/site/login']));
            Yii::$app->end();
        }
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'uploadpic'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                    //'uploadFilePath' => \Yii::getAlias('@common'),
                ]
            ],
        ];
    }
    /**
     * @brief 列表
     */
    public function actionIndex($treatid)
    {
        $searchmodel = new Welfaretemplate();
        $welfare = Welfare::find()->select(['id', 'title'])->where(['id' => $treatid])->one();
        $dataProvider = $searchmodel->search($treatid);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'welfare' => $welfare,
        ]);
    }

    /**
     * @brief 新增
     */
    public function actionCreate($treatid)
    {
        $model = new Welfaretemplate();
        $model->treatid = $treatid;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'treatid' => $treatid]);
        } else {
            $model->isrequired = 1;
            return $this->render('create', ['model' => $model]);
        }
    }
    /**
     * @brief 更新
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'treatid' => $model->treatid]);
        }

        return $this->render('update', ['model' => $model]);
    }
    /**
     * @brief 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }
    /**
     * @inheritdoc
     */
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Welfaretemplate();
        }
        if (($model = Welfaretemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
