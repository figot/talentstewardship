<?php
namespace b\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Hotelmanage;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * 酒店用户权限配置
 */
class HotelmanageController extends Controller
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
     * @inheritdoc
     */
    public function actionIndex()
    {
        $model = new Hotelmanage();
        $dataProvider = $model->search();
        return $this->render('index', [
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
     * @inheritdoc 新建酒店用户
     */
    public function actionCreateh()
    {
        $model = new Hotelmanage();
        $hotel = Hotelmanage::getHotelinfo();
        $user = Hotelmanage::getUserinfo();
        \Yii::warning('==============' . var_export(Yii::$app->getRequest()->post(), true));
        \Yii::warning('==============' . var_export($hotel, true));
        \Yii::warning('==============' . var_export($user, true));
        if ($model->load(Yii::$app->getRequest()->post())) {
            $model->isroot = 2;
            $model->username = $user[$model->user_id];
            $model->hotelname = $hotel[$model->hotelid];
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('createh', ['model' => $model, 'hotel' => $hotel, 'user' => $user]);
        }
    }
    /**
     * @inheritdoc 新建超级管理员
     */
    public function actionCreate()
    {
        $model = new Hotelmanage();
        $user = Hotelmanage::getUserinfo();
        if ($model->load(Yii::$app->getRequest()->post())) {
            $model->isroot = 1;
            $model->hotelid = 0;
            $model->username = $user[$model->user_id];
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', ['model' => $model, 'user' => $user]);
        }
    }
    /**
     * @inheritdoc
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
            return new Hotelmanage();
        }
        if (($model = Hotelmanage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
