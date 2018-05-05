<?php
namespace b\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Talentfiles;
use b\models\TalentCategory;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 *
 */
class TalentfilesController extends Controller
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
     * @brief 人才文件列表
     */
    public function actionIndex($talentcategoryid)
    {
        $searchmodel = new Talentfiles();
        $talenttemplate = Talentcategory::find()->select(['id', 'talentlevel'])->where(['id' => $talentcategoryid])->one();
        $dataProvider = $searchmodel->search($talentcategoryid);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'talenttemplate' => $talenttemplate,
        ]);
    }

    /**
     * @brief 新增
     */
    public function actionCreate($talentcategoryid)
    {
        $model = new Talentfiles();
        $model->talentcategoryid = $talentcategoryid;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'talentcategoryid' => $talentcategoryid]);
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
            return $this->redirect(['index', 'talentcategoryid' => $model->talentcategoryid]);
        }

        return $this->render('update', ['model' => $model]);
    }
    /**
     * @brief 审核
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        $hotel = Talentfiles::find()->where(['id' => $model->talentcategoryid])->one();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'talentcategoryid' => $model->talentcategoryid]);
        }

        return $this->render('review', ['model' => $model, 'hotel' => $hotel]);
    }
    /**
     * @brief 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $categoryid = $model->talentcategoryid;
        $model->delete();
        return $this->redirect(['index', 'talentcategoryid' => $categoryid]);
    }
    /**
     * @inheritdoc
     */
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Talentfiles();
        }
        if (($model = Talentfiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
