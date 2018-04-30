<?php
namespace b\controllers;

use b\models\Talent;
use yii\helpers\Url;
use b\models\Depart;
use b\models\Checkprojectapply;
use b\models\search\CheckprojectapplySearch;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * 项目申请
 */
class CheckprojectapplyController extends Controller
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
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => Yii::$app->params['hostname'],//图片访问路径前缀
                    "imagePathFormat" => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                ],
            ]
        ];
    }
    /**
     * @brief 列表
     */
    public function actionIndex()
    {
        $searchModel = new CheckprojectapplySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * @brief 创建
     */
    public function actionCreate()
    {
        $model = new Checkprojectapply();
        $department = Depart::getSecondDeparts();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', ['model' => $model, 'department' => $department]);
        }
    }
    /**
     * @brief 更新
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $department = Depart::getSecondDeparts();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model, 'department' => $department]);
    }
    /**
     * @brief 预览
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }
    /**
     * @brief 审核
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('review', ['model' => $model]);
    }
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Checkprojectapply();
        }
        if (($model = Checkprojectapply::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
