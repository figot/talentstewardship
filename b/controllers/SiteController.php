<?php
namespace b\controllers;

//use Faker\Provider\uk_UA\Company;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use b\models\LoginForm;
use b\models\Company;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $userClassName;
    public $user = null;
    public $userId = null;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'registration', 'uploadpic', 'success'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'chpwd'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
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
            'uploadpic'=>[
                'class' => 'common\widgets\pic_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                    //'uploadFilePath' => \Yii::getAlias('@common'),
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $this->layout = 'login.php';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @brief 公司注册
     */
    public function actionRegistration()
    {
        $this->layout = 'sign.php';
        $model = new $this->userClassName;
        $company = new Company();
        $model->setScenario('registration');
        if ($model->load(Yii::$app->request->post()) && $company->load(Yii::$app->request->post())) {
            $model->status = 2;
            $company->email = $model->email;
            if ($user = $model->signup()) {
                $company->user_id = $user->id;
                $company->username = $user->username;
                if ($company->save()) {
                    return $this->redirect(['success']);
                }
            }
        }

        return $this->render('registration', ['model' => $model, 'company' => $company]);
    }

    public function actionSuccess()
    {
        $this->layout = 'base.php';
        return $this->render('success');
    }

    public function actionChpwd()
    {
        $model = $this->findModel($this->userId);
        $model->setScenario('update');
        if($model->load(Yii::$app->request->post())){
            if($model->password){
                $model->setPassword($model->password);
                $model->generateAuthKey();
            }

            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('chpwd', [
                    'model' => $model,
                ]);
            }
        }else{
            return $this->render('chpwd', [
                'model' => $model,
            ]);
        }
    }

    protected function findModel($id)
    {
        $class = $this->userClassName;
        if (($model = $class::findIdentity($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
