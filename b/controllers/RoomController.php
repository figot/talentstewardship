<?php
namespace b\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Room;
use b\models\Hotel;
use b\models\search\RoomSearch;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 *
 */
class RoomController extends Controller
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
     * @brief 酒店房间列表
     */
    public function actionIndex($hotelid)
    {
        $hotelInfo = Hotel::find()->select(['id', 'hotelname'])->where(['id' => $hotelid])->one();
        $searchmodel = new Room();
        $dataProvider = $searchmodel->search($hotelid);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'hotelinfo' => $hotelInfo,
        ]);
    }

    /**
     * @brief 新增房间
     */
    public function actionCreate($hotelid)
    {
        $model = new Room();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'hotelid' => $hotelid]);
        } else {
            $hotelInfo = Hotel::find()->select(['id', 'hotelname'])->where(['id' => $hotelid])->all();
            $hotel = array();
            foreach ($hotelInfo as $value) {
                $hotel[$value['id']] = $value['hotelname'];
            }
            return $this->render('create', ['model' => $model, 'hotel' => $hotel]);
        }
    }
    /**
     * @brief 更新房间
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $hotel = $this->findHotel($model->hotelid);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'hotelid' => $model->hotelid]);
        }

        return $this->render('update', ['model' => $model, 'hotel' => $hotel]);
    }
    /**
     * @brief 审核
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        $hotel = Hotel::find()->where(['id' => $model->hotelid])->one();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'hotelid' => $model->hotelid]);
        }

        return $this->render('review', ['model' => $model, 'hotel' => $hotel]);
    }
    /**
     * @brief 删除房间
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $id = $model->hotelid;
        $model->delete();
        return $this->redirect(['index', 'hotelid' => $id]);
    }
    /**
     * @inheritdoc
     */
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Room();
        }
        if (($model = Room::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @brief 查找酒店
     */
    protected function findHotel($id)
    {
        $hotelInfo = Hotel::find()->select(['id', 'hotelname'])->where(['id' => $id])->all();
        $hotel = array();
        foreach ($hotelInfo as $value) {
            $hotel[$value['id']] = $value['hotelname'];
        }
        return $hotel;
    }
}
