<?php
namespace app\controllers;

use app\models\Depart;
use app\models\NeedsApplyFiles;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\Welfare;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use app\models\Needs;
use app\models\Talentinfo;
use app\models\Adminmessage;

class NeedsController extends ActiveController {
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
            'except' => ['getdepart'],
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
     * @brief 提交需求信息
     */
    public function actionSet() {
        $arrReq = $this->getRequestParams();
        $talent = Talentinfo::findOne(['user_id' => $this->userId]);
        if (empty($talent)) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['NOT_TALENT_INFO'], \Yii::$app->params['ErrMsg']['NOT_TALENT_INFO']);
        }
        $needs = new Needs();
        if (isset($arrReq['id'])) {
            $id = intval($arrReq['id']);
        } else {
            $id = null;
        }
        $needs->load($arrReq, '');

        if ($needs->validate()) {
            $id = $needs->saveData($this->userId, $arrReq['applyfile'], $id);
            if (!empty($id)) {
                if (is_array($arrReq['applyfile'])) {
                    $applyfiles = new NeedsApplyFiles();
                    $applyfiles->saveImgs($arrReq['applyfile'], $this->userId, $id);
                }
                $arrInput = array(
                    'status' => \Yii::$app->params['adminuser.msgstatus']['unread'],
                    'title' => '[需求申请]' . $arrReq['title'],
                    'content' => $arrReq['content'],
                    'url' => \Yii::$app->params['hostname'] . '/b/web/needs/review?id=' . $id,
                    'msgtype' => 2,
                    'department' => $arrReq['subdepart'],
                    'area' => '',
                );
                $this->setAdminMessage($arrInput);
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取需求部门
     */
    public function actionGetdepart() {
        $departs = Depart::getDeparts();
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $departs);
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