<?php
namespace b\controllers;

use b\models\Hotelmanage;
use Yii;
use yii\web\Controller;
use b\models\Adminmessage;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\Url;
use b\models\Userdepartmap;

/**
 * 版本控制
 */
class MsgController extends Controller
{
    public $user = null;
    public $userId = null;

    public function init()
    {
        /* 判断是否登录 */
        if (\Yii::$app->user->getIsGuest()) {
            $this->redirect(Url::toRoute(['/site/login']));
            Yii::$app->end();
        }
        $this->user = \yii::$app->user->identity;
        $this->userId = \Yii::$app->user->id;
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
        $searchModel = new Adminmessage();
        $userauth = Userdepartmap::find()->where(['user_id' => $this->userId])->one();
        $hotelauth = Hotelmanage::find()->where(['user_id' => $this->userId])->one();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $userauth, $hotelauth);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * @inheritdoc
     */
    public function actionView($id, $status=null)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save(false)) {
            return $this->redirect(['index']);
        }

        return $this->render('view', ['model' => $model]);
    }
    /**
     * @inheritdoc
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        $model->status = Yii::$app->params['adminuser.msgstatus']['readed'];
        if ($model->save(false)) {
            return $this->redirect(['index']);
        }

        return $this->render('view', ['model' => $model]);
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
            return new Adminmessage();
        }
        if (($model = Adminmessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
