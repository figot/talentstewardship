<?php
namespace b\controllers;

use b\models\Userdepartmap;
use Yii;
use yii\web\Controller;
use b\models\Version;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\Url;
use b\models\Depart;

/**
 * 用户与机构的配置
 */
class UserdepartmapController extends Controller
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
        ];
    }
    /**
     * @brief 列表
     */
    public function actionIndex()
    {
        $searchModel = new Userdepartmap();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::warning('===================' . var_export($dataProvider, true));
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
        $model = new Userdepartmap();
        $user = Userdepartmap::getUserinfo();
        $department = Depart::getSecondDepartsById();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model, 'department' => $department, 'user' => $user]);
        }
    }
    /**
     * @brief 更新
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = Userdepartmap::getUserinfo();
        $department = Depart::getSecondDepartsById();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model, 'department' => $department, 'user' => $user]);
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
            return new Userdepartmap();
        }
        if (($model = Userdepartmap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
