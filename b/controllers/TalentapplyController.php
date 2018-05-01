<?php
namespace b\controllers;

use b\models\Talent;
use b\models\Talentapply;
use b\models\TalentCategory;
use b\models\search\TalentapplySearch;
use b\models\Talentapplyfiles;
use b\models\Talentinfo;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * 人才认证申请
 */
class TalentapplyController extends Controller
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
        $searchModel = new TalentapplySearch();
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
        if (!empty($model)) {
            $user = $this->findUser($model->user_id);
        }
        return $this->render('view', ['model' => $model, 'files' => $files, 'user' => $user]);
    }
    /**
     * @brief 审核
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        $talentcategory = TalentCategory::find()->where(['id' => $model->talentcategoryid])->one();
        $talent = Talentinfo::find()->where(['user_id' => $model->user_id])->one();
        if (!empty($model)) {
            $user = $this->findUser($model->user_id);
        }
        $applyfiles = Talentapply::getApplyFiles($model->id, $model->talentcategoryid);
        if ($model->load(Yii::$app->getRequest()->post())) {
            $talent->category = $talentcategory->talentlevel;
            $talent->authstatus = $model->applystatus;
            $talent->catestatus = \Yii::$app->params['talent.catestatus']['talentauth'];
            if ($model->save() && $talent->save()) {
                return $this->redirect(['index', 'talentcategoryid' => $model->talentcategoryid]);
            }
        }

        return $this->render('review', ['model' => $model, 'user' => $user, 'require' => $applyfiles['require'], 'optional' => $applyfiles['optional']]);
    }
    protected function findModel($id)
    {
        if ($id == 0) {
            return new Talentapply();
        }
        if (($model = Talentapply::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findFiles($id)
    {
        if ($id == 0) {
            return new Talentapplyfiles();
        }
        if (($model = Talentapplyfiles::findImgs($id)) !== null) {
            return $model;
        } else {
            return new Talentapplyfiles();
        }
    }
    protected function findUser($id)
    {
        if ($id == 0) {
            return new Talent();
        }
        if (($model = Talent::getDataByUid($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
