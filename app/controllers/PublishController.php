<?php
namespace app\controllers;

use app\models\Project;
use f\models\Talentinfo;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\Cooperation;
use app\models\Recruit;
use app\models\Applier;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\Policyapply;
use app\models\Projectapply;
use app\models\ProjectApplyFiles;
use app\models\Adminmessage;

class PublishController extends ActiveController {
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
     * @return
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $this->user = \yii::$app->user->identity;
        $this->userId = \Yii::$app->user->id;

        return $action;
    }
    /**
     * @return  发布合作信息
     */
    public function actionCoop() {
        $arrReq = $this->getRequestParams();
        $coop = new Cooperation();
        $coop->load($arrReq, '');
        if ($coop->validate()) {
            if ($coop->saveData($this->userId, $this->userId)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @return  申报政策
     */
    public function actionPolicy() {
        $arrReq = $this->getRequestParams();
        $policy = new Policyapply();
        if (!empty($arrReq['id'])) {
            if ($policy->saveData(intval($arrReq['id']), $this->userId)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @return  申报项目
     */
    public function actionProject() {
        $arrReq = $this->getRequestParams();
        $project = new Projectapply();
        $talent = Talentinfo::findOne(['user_id' => $this->userId]);
        if (empty($talent)) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['NOT_TALENT_INFO'], \Yii::$app->params['ErrMsg']['NOT_TALENT_INFO']);
        }
        if (!empty($arrReq['id'])) {
            $applyid = $project->saveData(intval($arrReq['id']), $this->userId, $arrReq['remark']);
            if (!empty($applyid)) {
                if (is_array($arrReq['uploads'])) {
                    $applyfiles = new ProjectApplyFiles();
                    $applyfiles->saveImgs($applyid, $this->userId, $arrReq['uploads']);
                }
            }
            $pro = Project::find()->where(['id' => $arrReq['id']])->one();
            if (!empty($pro)) {
                $arrInput = array(
                    'status' => \Yii::$app->params['adminuser.msgstatus']['unread'],
                    'title' => '[项目申报]' . $pro->title,
                    'content' => $pro->content,
                    'url' => \Yii::$app->params['hostname'] . '/b/web/projectapply/review?id=' . $applyid,
                    'msgtype' => 2,
                    'department' => $pro->department,
                    'area' => '',
                );
                $this->setAdminMessage($arrInput);
            }
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**@brief 提交招聘应聘信息
     * @return
     */
    public function actionRecruit() {
        $arrReq = $this->getRequestParams();
        if ($arrReq['type'] == 1) {
            $recruit = new Recruit();
            $recruit->load($arrReq, '');
            if ($recruit->validate()) {
                if ($recruit->saveData($this->userId)) {
                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
                }
            } else {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
            }
        } else if(in_array($arrReq['type'], array(2,3))) {
            $applier = new Applier();
            $applier->load($arrReq, '');
            if ($applier->validate()) {
                if ($applier->saveData($this->userId)) {
                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
                }
            } else {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
            }
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
        $adminmsg->department = $arrInput['department'];
        $adminmsg->save();
    }
}