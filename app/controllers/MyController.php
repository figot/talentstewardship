<?php
namespace app\controllers;

use app\models\Message;
use b\models\Reservation;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\Talentinfo;
use app\models\Education;
use app\models\Experience;
use app\models\Talentcard;
use app\models\Honor;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\UploadImg;
use app\models\UploadImgs;
use yii\web\UploadedFile;
use app\models\Treatapply;
use app\models\Needs;
use app\models\Project;
use app\models\Projectapply;
use app\models\ValidCheck;
use app\models\Educationlevelconf;

class MyController extends ActiveController
{
    public $modelClass = 'app\models\User';
    public $user = null;
    public $userId = null;

    /**
     * @return
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'except' => [],
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['contentNegotiator']['formats'] = '';
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * @brief
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $this->user = \yii::$app->user->identity;
        $this->userId = \Yii::$app->user->id;

        return $action;
    }

    /**
     * @brief 获取我的福利
     */
    public function actionWelfare()
    {
        $arrReq = $this->getRequestParams();
        $talentinfo = new Talentinfo();
        $talentinfo->load($arrReq, '');
        if ($talentinfo->validate()) {
            if ($talentinfo->saveData($this->userId)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }

    /**
     * @brief 获取我的待遇
     */
    public function actionTreat()
    {
        $apply = new Treatapply();
        $model = $apply->getByUid($this->userId);
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
    }

    /**
     * @brief 获取我的需求
     */
    public function actionNeeds()
    {
        $needs = new Needs();
        $model = $needs->get($this->userId);

        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
    }

    /**
     * @brief 获取我的项目
     */
    public function actionProject()
    {
        $arrReq = $this->getRequestParams();
        $validator = new ValidCheck();
        $myproject = new Projectapply();
        if ($validator->load($arrReq, '') && $validator->validate()) {
            $model = $myproject->getMyProject($validator->rn, $validator->pn, $this->userId);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }

    /**
     * @brief 获取人才详细信息
     */
    public function actionGetinfo()
    {
        $arrReq = $this->getRequestParams();
        $talentinfo = new Talentinfo();
        $talentinfo->load($arrReq, '');
        $model = $talentinfo->getData($this->userId);
        if ($model) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取我的待遇，我的需求，我的项目，酒店订单数量
     */
    public function actionGetnums()
    {
        $arrReq = $this->getRequestParams();
        $treatapplynums = Treatapply::find()->where(['user_id' => $this->userId])->count();
        $needsnums = Needs::find()->where(['user_id' => $this->userId])->count();
        $projectnums = Projectapply::find()->where(['user_id' => $this->userId])->count();
        $hotelordernums = Reservation::find()->where(['user_id' => $this->userId])->count();
        $msgnums = Message::find()->where(['user_id' => $this->userId])->count();
        $talentinfo = Talentinfo::find()->where(['user_id' => $this->userId])->one();

        $arrRes = array(
            'treat_nums' => $treatapplynums,
            'need_nums' => $needsnums,
            'project_nums' => $projectnums,
            'hotelorder_nums' => $hotelordernums,
            'msg_unread_nums' => $msgnums,
        );

        if (!empty($talentinfo)) {
            $arrRes['category'] = $talentinfo->category;
            $arrRes['authstatus'] = $talentinfo->authstatus;
            if ($talentinfo->catestatus == \Yii::$app->params['talent.catestatus']['eduauth']) {
                $pretalent = Educationlevelconf::find()->where(['educate' => $talentinfo->maxdegree])->one();
                $arrRes['category'] = $pretalent['talentlevel'];
            } else if ($arrRes['catestatus'] == \Yii::$app->params['talent.catestatus']['talentauth']) {

            }
        }

        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $arrRes);
    }
}