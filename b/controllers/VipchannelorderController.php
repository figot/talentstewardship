<?php
namespace b\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Vipchannelorder;
use b\models\search\VipchannelorderSearch;
use yii\web\NotFoundHttpException;
use dosamigos\qrcode\QrCode;
use yii\web\Response;
use yii\helpers\Url;

/**
 * vipchannel订单
 */
class VipchannelorderController extends Controller
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
        $searchModel = new VipchannelorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
     * @inheritdoc
     */
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Vipchannelorder();
        }
        if (($model = Vipchannelorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
