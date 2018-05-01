<?php
namespace b\controllers;

use b\models\Depart;
use b\models\Userdepartmap;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Project;
use b\models\search\ProjectSearch;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * policy controller
 */
class ProjectController extends Controller
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
     * @brief
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => Yii::$app->params['hostname'],//图片访问路径前缀
                    "imagePathFormat" => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                ],
            ]
        ];
    }
    /**
     * @brief 列表
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
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

        return $this->render('view', ['model' => $model]);
    }
    /**
     * @brief 创建
     */
    public function actionCreate()
    {
        $model = new Project();
        $department = Depart::getSecondDeparts();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', ['model' => $model, 'department' => $department]);
        }
    }
    /**
     * @brief 更新
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $department = Depart::getSecondDeparts();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model, 'department' => $department]);
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
     * @brief 审核
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save(false)) {
            return $this->redirect(['index']);
        }

        return $this->render('review', ['model' => $model]);
    }
    /**
     * @brief
     */
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Project();
        }
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
