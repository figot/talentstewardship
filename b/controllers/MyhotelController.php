<?php
namespace b\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Hotel;
use b\models\Room;
use b\models\Hotelorder;
use b\models\Hotelimages;
use b\models\TalentCategory;
use b\models\Area;
use b\models\search\HotelSearch;
use yii\web\NotFoundHttpException;
use dosamigos\qrcode\QrCode;
use yii\helpers\Url;

/**
 * 我的酒店
 */
class MyhotelController extends Controller
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
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => Yii::$app->params['hostname'],//图片访问路径前缀
                    "imagePathFormat" => "/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ],
            'upload_more'=>[
                'class' => 'common\widgets\batch_upload\UploadAction'
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $searchModel = new HotelSearch();
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
    public function actionImages($id)
    {
        $model = new Hotelimages();
        $arrRequest = Yii::$app->getRequest()->post();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if (!empty($arrRequest['Hotelimages']['imageurl'])) {
                $model->saveImgs($id, $arrRequest['Hotelimages']['imageurl']);
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('images', ['model' => $model]);
        }
    }
    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model = new Hotel();
        $levelconf = TalentCategory::getLevels();
        $areaconf = Area::getAreas();
        if ($model->load(Yii::$app->getRequest()->post())) {
            $arrData = \Yii::$app->getRequest()->post();
            $model->suitper = implode(',', array_values($arrData['Hotel']['suitperlist']));
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', ['model' => $model, 'levelconf' => $levelconf, 'areaconf' => $areaconf]);
        }
    }
    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $levelconf = TalentCategory::getLevels();
        $areaconf = Area::getAreas();
        if ($model->load(Yii::$app->getRequest()->post())) {
            $arrData = \Yii::$app->getRequest()->post();
            $model->suitper = implode(',', array_values($arrData['Hotel']['suitperlist']));
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', ['model' => $model, 'levelconf' => $levelconf, 'areaconf' => $areaconf]);
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
            return new Hotel();
        }
        if (($model = Hotel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @inheritdoc
     */
    protected function findHotelImgs($id)
    {
        if ($id == 0) {
            return new Hotelimages();
        }
        if (($model = Hotel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @brief
     */
    public function actionQrcode($id)
    {
        \Yii::$app->response->format = Response::FORMAT_RAW;
        $url = \Yii::$app->request->getHostInfo() . '/app/web/qrcode/hotelcheck?pid=' . $id . '&access_token=';
        return QrCode::png($url);    //调用二维码生成方法
    }
}
