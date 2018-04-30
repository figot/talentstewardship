<?php
namespace b\controllers;

use b\models\Company;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\search\CompanySearch;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use linslin\yii2\curl;

/**
 * 企业审核页面
 */
class CompanyController extends Controller
{
    public $userClassName;
    public $user = null;
    public $userId = null;

    public function init()
    {
        /* 判断是否登录 */
        if (\Yii::$app->user->getIsGuest()) {
            $this->redirect(Url::toRoute(['/site/login']));
            Yii::$app->end();
        }
        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->getUser()->identityClass;
            $this->userClassName = $this->userClassName ? : 'common\models\AdminModel';
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
     * @brief
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
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
        if ($model->load(Yii::$app->getRequest()->post()) && $model->setStatus()) {
//            \Yii::warning('==================22222============');
//            if ($model->status == 2) {
//                $curl = new curl\Curl();
//                $response = $curl->setOption(
//                    CURLOPT_POSTFIELDS,
//                    http_build_query(array(
//                            'action' => 'assign',
//                            'roles' => array(
//                                '企业用户',
//                            ),
//                        )
//                    ))->post(\Yii::$app->params['hostname'] . "/b/web/admin/assignment/assign?id=" . $this->userId);
//                \Yii::warning('==================22222============' . $curl->responseCode);
//            }
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
            return new Company();
        }
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
