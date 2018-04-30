<?php
namespace b\controllers;

use b\models\Project;
use b\models\Projecttemplate;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Talentfiles;
use b\models\TalentCategory;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * 项目申报模板列表
 */
class ProjecttemplateController extends Controller
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
    public function actionIndex($projectid)
    {
        $searchmodel = new Projecttemplate();
        $projecttemplate = Project::find()->select(['id', 'title'])->where(['id' => $projectid])->one();
        $dataProvider = $searchmodel->search($projectid);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'projecttemplate' => $projecttemplate,
        ]);
    }

    /**
     * @brief 新增
     */
    public function actionCreate($projectid)
    {
        $model = new Projecttemplate();
        $model->projectid = $projectid;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'projectid' => $projectid]);
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
            return $this->redirect(['index', 'projectid' => $model->projectid]);
        }

        return $this->render('update', ['model' => $model]);
    }
    /**
     * @brief 审核
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        $hotel = Talentfiles::find()->where(['id' => $model->projectid])->one();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'projectid' => $model->projectid]);
        }

        return $this->render('review', ['model' => $model, 'hotel' => $hotel]);
    }
    /**
     * @brief 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index', 'projectid' => $model->projectid]);
    }
    /**
     * @inheritdoc
     */
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Projecttemplate();
        }
        if (($model = Projecttemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
