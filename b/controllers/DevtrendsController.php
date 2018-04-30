<?php
namespace b\controllers;

use b\models\Devtrends;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\search\DevtrendsSearch;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * 研发平台动态
 */
class DevtrendsController extends Controller
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
                    "imagePathFormat" => "/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $searchModel = new DevtrendsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * @inheritdoc
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }
    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model = new Devtrends();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->getAuthManager()->remove($model->item);
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Devtrends();
        }
        if (($model = Devtrends::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
