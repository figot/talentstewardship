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
        //$welfare = Welfare::find()->where(['id' => $model->treatid])->one();
        $applyfiles = Welfareapply::getApplyFiles($model->id, $model->treatid);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('review', ['model' => $model, 'require' => $applyfiles['require'], 'optional' => $applyfiles['optional']]);
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
