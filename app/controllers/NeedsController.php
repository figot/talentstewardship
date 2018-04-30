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
        $needsfile = new NeedsApplyFiles();
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
//        $departs = array(
//            0 => array(
//                'department' => '市委宣传部',
//                'subdepart' => array(
//                    "石城县",
//                    "寻乌县",
//                    "会昌县",
//                    "瑞金市（瑞金经开区）",
//                    "于都县",
//                    "宁都县",
//                    "兴国县",
//                    "定南县",
//                    "全南县",
//                    "龙南县（  龙南经开区）",
//                    "安远县",
//                    "崇义县",
//                    "上犹县",
//                    "大余县",
//                    "信丰县",
//                    "赣县区 （赣州高新区）",
//                    "南康区",
//                    "章贡区"
//                ),
//            ),
//            1 => array(
//                'department' => '市委统战部',
//                'subdepart' => array(
//                    "石城县",
//                    "寻乌县",
//                    "会昌县",
//                    "瑞金市（瑞金经开区）",
//                    "于都县",
//                    "宁都县",
//                    "兴国县",
//                    "定南县",
//                    "全南县",
//                    "龙南县（  龙南经开区）",
//                    "安远县",
//                    "崇义县",
//                    "上犹县",
//                    "大余县",
//                    "信丰县",
//                    "赣县区 （赣州高新区）",
//                    "南康区",
//                    "章贡区"
//                ),
//            ),
//            2 => array(
//                'department' => '市直机关工委',
//                'subdepart' => array(
//                    "石城县",
//                    "寻乌县",
//                    "会昌县",
//                    "瑞金市（瑞金经开区）",
//                    "于都县",
//                    "宁都县",
//                    "兴国县",
//                    "定南县",
//                    "全南县",
//                    "龙南县（  龙南经开区）",
//                    "安远县",
//                    "崇义县",
//                    "上犹县",
//                    "大余县",
//                    "信丰县",
//                    "赣县区 （赣州高新区）",
//                    "南康区",
//                    "章贡区"
//                ),
//            ),
//        );
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $departs);
    }
}