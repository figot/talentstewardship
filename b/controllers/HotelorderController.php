<?php
namespace b\controllers;

use b\models\Talentinfo;
use b\models\Hotel;
use b\models\Adminmessage;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Hotelorder;
use b\models\search\HotelorderSearch;
use yii\web\NotFoundHttpException;
use dosamigos\qrcode\QrCode;
use yii\web\Response;
use yii\helpers\Url;
use kartik\mpdf\Pdf;
use b\models\TalentCategory;

/**
 * 酒店订单
 */
class HotelorderController extends Controller
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
        $searchModel = new HotelorderSearch();
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
        $talent = Talentinfo::getInfo($model->user_id);
        $hotel = Hotel::find()->where(['id' => $model->hotelid])->one();
        $talent['category'] = $this->getTalentLevelName($talent);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'hotelid' => $model->hotelid]);
        }

        return $this->render('review', ['model' => $model, 'hotel' => $hotel, 'talent' => $talent, 'education' => $talent['education']]);
    }
    /**
     * @brief 入住确认
     */
    public function actionCheckin($id)
    {
        $model = $this->findModel($id);
        $talent = Talentinfo::getInfo($model->user_id);
        $hotel = Hotel::find()->where(['id' => $model->hotelid])->one();
        $talent['category'] = $this->getTalentLevelName($talent);
        if ($model->load(Yii::$app->getRequest()->post())) {
            $model->chkindt = time();
            if ($model->save()) {
                $arrInput = array(
                    'status' => \Yii::$app->params['adminuser.msgstatus']['unread'],
                    'title' => $model->user_name . '入住酒店' . $hotel->hotelname . '确认通知',
                    'content' => "本人". $model->user_name . "身份证" . $model->id_number . "联系电话" . $talent['mobile'] . "在" . $hotel->hotelname . "入住" . $model->roomtype . ceil(abs(strtotime(date('Y-m-d',$model->enddt)) - strtotime(date('Y-m-d',$model->startdt)))) / 86400 . "天, 确认无误,详细信息请查阅酒店订单列表",
                    'url' => \Yii::$app->params['hostname'] . '/b/web/hotelorder/review?id=' . $id,
                    'msgtype' => 1,
                    'area' => $hotel->area,
                );
                $this->setAdminMessage($arrInput);
                return $this->redirect(['index', 'hotelid' => $model->hotelid]);
            }
        }

        return $this->render('checkin', ['model' => $model, 'hotel' => $hotel,  'talent' => $talent, 'education' => $talent['education']]);
    }
    /**
     * @brief 转为pdf
     */
    public function actionReport($id, $status=null) {
        $model = $this->findModel($id);
        if ($status == 3) {
            $model->status = $status;
            $model->chkoutdt = time();
            $model->save();
        }
        $talent = Talentinfo::getInfo($model->user_id);
        $hotel = Hotel::find()->where(['id' => $model->hotelid])->one();
        $talent['category'] = $this->getTalentLevelName($talent);
        $content = $this->renderPartial('report', ['model' => $model, 'hotel' => $hotel,  'talent' => $talent, 'education' => $talent['education']]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_BLANK,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => [
                'title' => '赣州市人才管家酒店离店确认单',
                'autoLangToFont' => true,    //这几个配置加上可以显示中文
                'autoScriptToLang' => true,  //这几个配置加上可以显示中文
                'autoVietnamese' => true,    //这几个配置加上可以显示中文
                'autoArabic' => true,        //这几个配置加上可以显示中文
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>['赣州市人才管家酒店离店确认单'],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    /**
     * @brief 离店确认
     */
    public function actionCheckout($id)
    {
        $model = $this->findModel($id);
        $talent = Talentinfo::getInfo($model->user_id);
        $hotel = Hotel::find()->where(['id' => $model->hotelid])->one();
        $talent['category'] = $this->getTalentLevelName($talent);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index', 'hotelid' => $model->hotelid]);
        }

        return $this->render('checkout', ['model' => $model, 'hotel' => $hotel,  'talent' => $talent, 'education' => $talent['education']]);
    }
    /**
     * @inheritdoc
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $talent = Talentinfo::getInfo($model->user_id);
        $hotel = Hotel::find()->where(['id' => $model->hotelid])->one();
        $talent['category'] = $this->getTalentLevelName($talent);
        return $this->render('view', ['model' => $model, 'hotel' => $hotel,  'talent' => $talent, 'education' => $talent['education']]);
    }
    /**
     * @inheritdoc
     */
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Hotelorder();
        }
        if (($model = Hotelorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @inheritdoc
     */
    protected function getTalentLevelName($talent) {
        $talentcate = array();
        $pretalent = TalentCategory::find(['id', 'educate', 'talentlevel'])->where(['authmethod' => \Yii::$app->params['talent.catestatus']['eduauth']])->asArray()->all();
        foreach ($pretalent as $v) {
            $talentcate[$v['id']] = $v['talentlevel'];
        }
        if (isset($talentcate[$talent['category']])) {
            return $talentcate[$talent['category']];
        } else {
            return '';
        }
    }
    /**
     * @inheritdoc
     */
    protected function setAdminMessage($arrInput) {
        $adminmsg = new Adminmessage();
        $adminmsg->status = \Yii::$app->params['adminuser.msgstatus']['unread'];
        $adminmsg->title = $arrInput['title'];
        $adminmsg->content = $arrInput['content'];
        $adminmsg->url = $arrInput['url'];
        $adminmsg->msgtype = $arrInput['msgtype'];
        $adminmsg->area = $arrInput['area'];
        $adminmsg->save();
    }
}
