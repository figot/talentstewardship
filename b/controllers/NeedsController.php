<?php
namespace b\controllers;

use b\models\Needsapplyfiles;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Needs;
use b\models\search\NeedsSearch;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use kartik\mpdf\Pdf;
use yii\data\ActiveDataProvider;
use b\models\Userdepartmap;

/**
 * 资讯
 */
class NeedsController extends Controller
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
        $searchModel = new NeedsSearch();
        $userauth = Userdepartmap::find()->where(['user_id' => $this->userId])->one();
        if (isset($userauth->subdepartid)) {
            $departid = $userauth->subdepartid;
        } else {
            $departid = null;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $departid);
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
        $applyfiles = $this->findFiles($id);

        return $this->render('view', ['model' => $model, 'applyfiles' => $applyfiles]);
    }
    /**
     * @brief 转为pdf
     */
    public function actionReport($id) {
        $model = $this->findModel($id);
        $applyfiles = $this->findFiles($id);
        $content = $this->renderPartial('view', ['model' => $model, 'applyfiles' => $applyfiles]);

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
                'title' => '赣州市人才管家需求审核',
                'autoLangToFont' => true,    //这几个配置加上可以显示中文
                'autoScriptToLang' => true,  //这几个配置加上可以显示中文
                'autoVietnamese' => true,    //这几个配置加上可以显示中文
                'autoArabic' => true,        //这几个配置加上可以显示中文
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>['赣州市人才管家需求审核'],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    /**
     * @brief 创建
     */
    public function actionCreate()
    {
        $model = new Needs();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }
    /**
     * @brief 审核
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        $applyfiles = $this->findFiles($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('review', ['model' => $model, 'applyfiles' => $applyfiles]);
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
            return new Needs();
        }
        if (($model = Needs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findFiles($id)
    {
        if ($id == 0) {
            return new Needsapplyfiles();
        }
        if (($model = Needsapplyfiles::findImgs($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
