<?php
namespace b\controllers;

use b\models\Welfare;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Welfareapply;
use b\models\Welfareapplyfiles;
use b\models\search\WelfareapplySearch;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use kartik\mpdf\Pdf;

/**
 * 待遇享受
 */
class WelfareapplyController extends Controller
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
     * @brief 转为pdf
     */
    public function actionReport($id) {
        $model = $this->findModel($id);
        $welfare = Welfare::find()->where(['id' => $model->treatid])->one();
        $applyfiles = Welfareapply::getApplyFiles($model->id, $model->treatid);
        $content = $this->renderPartial('report', ['model' => $model, 'require' => $applyfiles['require'], 'optional' => $applyfiles['optional'], 'welfare' => $welfare]);

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
                'title' => '赣州市人才管家专属待遇审核',
                'autoLangToFont' => true,    //这几个配置加上可以显示中文
                'autoScriptToLang' => true,  //这几个配置加上可以显示中文
                'autoVietnamese' => true,    //这几个配置加上可以显示中文
                'autoArabic' => true,        //这几个配置加上可以显示中文
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>['赣州市人才管家专属待遇审核'],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    /**
     * @brief 列表
     */
    public function actionIndex()
    {
        $searchModel = new WelfareapplySearch();
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
        $files = $this->findFiles($id);

        return $this->render('view', ['model' => $model, 'files' => $files]);
    }
    /**
     * @brief 审核
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        $welfare = Welfare::find()->where(['id' => $model->treatid])->one();
        $applyfiles = Welfareapply::getApplyFiles($model->id, $model->treatid);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('review', ['model' => $model, 'require' => $applyfiles['require'], 'optional' => $applyfiles['optional'], 'welfare' => $welfare]);
    }
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Welfareapply();
        }
        if (($model = Welfareapply::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findFiles($id)
    {
        if ($id == 0) {
            return new Welfareapplyfiles();
        }
        if (($model = Welfareapplyfiles::findImgs($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
