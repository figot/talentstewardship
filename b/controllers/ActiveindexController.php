<?php
namespace b\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Activeindex;
use b\models\Activeindexconf;
use yii\web\NotFoundHttpException;
use b\models\Area;

/**
 * 人才活跃指数配置
 */
class ActiveindexController extends Controller
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
        $searchModel = new Activeindex();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
     * @brief 创建
     */
    public function actionCreate()
    {
        $model = new Activeindex();
        $areaconf = Area::getAreas();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', ['model' => $model, 'areaconf' => $areaconf]);
        }
    }
    /**
     * @brief 更新
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $areaconf = Area::getAreas();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', ['model' => $model, 'areaconf' => $areaconf]);
    }
    /**
     * @brief 系数配置
     */
    public function actionCoff()
    {
        $model = new Activeindexconf();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('coff', ['model' => $model]);
        }
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
    /**
     * @brief 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Activeindex();
        }
        if (($model = Activeindex::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
