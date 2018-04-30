<?php
namespace b\controllers;

use b\models\Education;
use b\models\Experience;
use b\models\Honor;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\Talent;
use b\models\TalentCategory;
use b\models\search\TalentSearch;
use b\models\search\HonorSearch;
use b\models\search\ExperienceSearch;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * 人才信息
 */
class TalentController extends Controller
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
     * @inheritdoc
     */
    public function actionIndex()
    {
        $searchModel = new TalentSearch();
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
        if (!empty($model)) {
            $education = Education::find()->where(['user_id' => $model->user_id])->one();
            if (empty($education)) {
                $education = new Education();
            }
            $honorModel = new HonorSearch();
            $honor = $honorModel->search($model);
            $expModel = new ExperienceSearch();
            $exp = $expModel->search($model);
        }

        return $this->render('view', ['model' => $model, 'education' => $education, 'honor' => $honor, 'exp' => $exp]);
    }
    /**
     * @inheritdoc
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        $levelconf = TalentCategory::getLevels();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save(false)) {
            return $this->redirect(['index']);
        }
        return $this->render('review', ['model' => $model, 'levelconf' => $levelconf]);
    }
    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model = new Talent();
        $levelconf = TalentCategory::getLevels();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', ['model' => $model, 'levelconf' => $levelconf]);
        }
    }
    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $levelconf = TalentCategory::getLevels();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model, 'levelconf' => $levelconf]);
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
            return new Talent();
        }
        if (($model = Talent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
