<?php
namespace b\controllers;

use Yii;
use yii\web\Controller;
use b\models\Help;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\Url;

/**
 * 帮助中心
 */
class HelpController extends Controller
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
            ],
        ];
    }
    /**
     * @brief 列表
     */
    public function actionIndex()
    {
        $searchModel = new Help();
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
     * @brief 创建
     */
    public function actionCreate()
    {
        $model = new Help();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
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
            return $this->redirect(['index']);
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
            return new Help();
        }
        if (($model = Help::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
