<?php
namespace app\controllers;

use app\models\BoleRewardApply;
use app\models\Honorfiles;
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
use app\models\ValidCheck;
use linslin\yii2\curl;
use keltstr\simplehtmldom\SimpleHTMLDom as SHD;
use yii\helpers\HtmlPurifier;
use dosamigos\qrcode\QrCode;
use app\models\Talentactiveindex;
use app\models\Upload;
use app\models\Educationlevelconf;
use app\models\Talentapply;

class TalentController extends ActiveController {
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
            'except' => ['getlist', 'getcategory', 'gethonortype', 'qrcode', 'activeindex', 'getpolvisage','geteducationtype'],
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
     * @brief 设置人才详细个人信息
     */
    public function actionSetinfo() {
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
     * @brief 获取人才详细信息
     */
    public function actionGetinfo() {
        $arrReq = $this->getRequestParams();
        $talentinfo = new Talentinfo();
        $talentinfo->load($arrReq, '');
        $model = $talentinfo->getData($this->userId);
        $arrRes = $model->attributes;
        if (!empty($arrRes['idcardup'])) {
            $arrRes['idcardupurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $arrRes['idcardup'];
        }
        if (!empty($arrRes['idcarddown'])) {
            $arrRes['idcarddownurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $arrRes['idcarddown'];
        }
        if (!empty($arrRes['portrait'])) {
            $arrRes['portraitsign'] = $arrRes['portrait'];
            $arrRes['portrait'] = \Yii::$app->request->getHostInfo() . '/image/app/' . $arrRes['portrait'];
        }
        if ($arrRes['catestatus'] == \Yii::$app->params['talent.catestatus']['eduauth']) {
            $pretalent = Educationlevelconf::find()->where(['educate' => $arrRes['maxdegree']])->one();
            $arrRes['category'] = $pretalent['talentlevel'];
        } else if ($arrRes['catestatus'] == \Yii::$app->params['talent.catestatus']['talentauth']) {

        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $arrRes);
    }
    /**
     * @brief 设置教育信息
     */
    public function actionSetedu() {
        $arrReq = $this->getRequestParams();
        $talent = Talentinfo::findOne(['user_id' => $this->userId]);
        if (empty($talent)) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['NOT_TALENT_INFO'], \Yii::$app->params['ErrMsg']['NOT_TALENT_INFO']);
        }
//        if (!empty($arrReq['school']) && !empty($arrReq['degree'])) {
//            $curl = new curl\Curl();
//            $response = $curl->get("http://www.chsi.com.cn/xlcx/bg.do?vcode=" . trim($arrReq['vcode']) . "&srcid=bgcx");
//            $html_source = SHD::str_get_html($response);
//            $eduAuthResult = strval($html_source->getElementById('resultTable'));
//
//            if (strpos($eduAuthResult, $arrReq['school']) === FALSE) {
//                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SCHOOL_AUTH_FAIL'], \Yii::$app->params['ErrMsg']['SCHOOL_AUTH_FAIL']);
//            } else if (strpos($eduAuthResult, $arrReq['degree']) === FALSE) {
//                return $this->_buildReturn(\Yii::$app->params['ErrCode']['DEGREE_AUTH_FAIL'], \Yii::$app->params['ErrMsg']['DEGREE_AUTH_FAIL']);
//            }
//            $talent = Talentinfo::findIdentity($this->userId);
//            if (strpos($eduAuthResult, $talent->id_number) === FALSE) {
//                return $this->_buildReturn(\Yii::$app->params['ErrCode']['ID_CARD_AUTH_FAIL'], \Yii::$app->params['ErrMsg']['ID_CARD_AUTH_FAIL']);
//            }
//            $arrReq['degreereport'] = $eduAuthResult;
//        }
        if (!empty($arrReq['vcode'])) {
            $curl = new curl\Curl();
            $response = $curl->get("http://www.chsi.com.cn/xlcx/bg.do?vcode=" . trim($arrReq['vcode']) . "&srcid=bgcx");
            $html_source = SHD::str_get_html($response);
            $eduAuthResult = strval($html_source->getElementById('resultTable'));
            if (empty($eduAuthResult)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['VCODE_ERROR'], \Yii::$app->params['ErrMsg']['VCODE_ERROR']);
            }
            $regex1="/<div class=\"cnt1\".*?>.*?<\/div>/ism";
            $regresult = preg_match_all($regex1,$eduAuthResult,$match, PREG_PATTERN_ORDER);
            //学历和学籍网页写法不一样
            if (empty($regresult)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['VCODE_ERROR'], \Yii::$app->params['ErrMsg']['VCODE_ERROR']);
            } else {
                if (isset($match[0][4])) {
                    $arrReq['school'] = strip_tags($match[0][4]);
                }
                if (isset($match[0][5])) {
                    $arrReq['degree'] = strip_tags($match[0][5]);
                }
                if (isset($match[0][6])) {
                    $arrReq['institute'] = strip_tags($match[0][6]);
                }
                if (isset($match[0][14])) {
                    $arrReq['graduation_year'] = trim(strip_tags($match[0][14]));
                }
            }
            $arrReq['degreereport'] = $eduAuthResult;
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['EMPTY_VCODE'], \Yii::$app->params['ErrMsg']['EMPTY_VCODE']);
        }
        $education = new Education();
        $education->load($arrReq, '');
        $talentinfo = new Talentinfo();
        if ($education->validate()) {
            if ($education->saveData($this->userId)) {
                $model = $education->getEducationByLast($this->userId);
                if (empty($model)) {
                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['DEGREE_IS_EMPTY'], \Yii::$app->params['ErrMsg']['DEGREE_IS_EMPTY']);
                }
                if (Education::authEducation($model)) {
                    $arrRes = ['maxdegree' => $model->degree];
                }
                if ($talentinfo->saveMaxDegree($this->userId, $model->degree)) {
                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $arrRes);
                }
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
    }
    /**
     * @brief 获取教育信息
     */
    public function actionGetedu() {
        $arrReq = $this->getRequestParams();
        $education = new Education();
        $education->load($arrReq, '');
        $model = $education->getData($this->userId, $this->user);
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
    }
    /**
     * @brief 获取教育类别
     *
     */
    public function actionGeteducationtype()
    {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.education.degree']);
    }
    /**
     * @brief 获取荣誉类别
     *
     */
    public function actionGethonortype()
    {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.honortype']);
    }
    /**
     * @brief 设置荣誉信息
     */
    public function actionSethonor() {
        $arrReq = $this->getRequestParams();
        $honor = new Honor();
        $talentinfo = Talentinfo::find()->where(['user_id' => $this->userId])->one();
        $honor->load($arrReq, '');
        if ($honor->validate()) {
            $honorid = $honor->saveData($this->userId);
            if (!empty($honorid)) {
                if (is_array($arrReq['certificate'])) {
                    $applyfiles = new Honorfiles();
                    $applyfiles->saveImgs($honorid, $this->userId, $arrReq['certificate']);
                }
                if (!empty($talentinfo)) {
                    $talentinfo->authstatus = \Yii::$app->params['talent.authstatus']['authing'];
                    if (!$talentinfo->save(false)) {
                        throw new \Exception();
                    }
                }
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取荣誉信息
     */
    public function actionGethonor() {
        $arrReq = $this->getRequestParams();
        $honor = new Honor();
        $honor->load($arrReq, '');
        $model = $honor->getData($this->userId);
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
    }
    /**
     * @brief  设置履历信息
     */
    public function actionSetexp() {
        $arrReq = $this->getRequestParams();
        $experience = new Experience();
        $experience->load($arrReq, '');
        if ($experience->validate()) {
            if ($experience->saveData($this->userId, $this->user)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief  删除履历信息
     */
    public function actionDelexp() {
        $arrReq = $this->getRequestParams();
        $model = Experience::findOne(['id' => $arrReq['id'], 'user_id' => $this->userId]);
        if (!empty($model)) {
            $model->delete();
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取履历信息
     */
    public function actionGetexp() {
        $arrReq = $this->getRequestParams();
        $experience = new Experience();
        $experience->load($arrReq, '');
        $model = $experience->getData($this->userId, $this->user);
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
    }
    /**
     * @brief 根据id获取履历信息
     */
    public function actionGetexpbyid() {
        $arrReq = $this->getRequestParams();
        $experience = new Experience();
        $experience->load($arrReq, '');
        $model = $experience->getDataById();
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
    }
    /**
     * @brief 上传文件
     */
    public function actionUpload()
    {
        $model = new UploadImg();

        if (\Yii::$app->request->isPost) {
            //获取单个文件用 getInstanceByName
            $model->single = UploadedFile::getInstanceByName('imagefile');

            if (!$model->upload()) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['UPLOAD_IMG_FAIL'], \Yii::$app->params['ErrMsg']['UPLOAD_IMG_FAIL']);
            }

            unset($model->single);
        }

        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model->filesign);
    }
    /**
     * @brief 上传多个文件
     */
    public function actionMuploads()
    {
        $model = new UploadImgs();

        if (\Yii::$app->request->isPost) {
            //获取多个文件
            $model->multiple = UploadedFile::getInstancesByName('imagefilelist');
            if (!$model->uploadMultiple()) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['UPLOAD_IMG_FAIL'], \Yii::$app->params['ErrMsg']['UPLOAD_IMG_FAIL']);
            }
            unset($model->multiple);
        }

        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'],$model->filesignlist);
    }
    /**
     * @brief   人才认证
     */
    public function actionAuthentication() {
        $talentcard = new Talentcard();
        if ($talentcard->saveData($this->userId)) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
//    /**
//     * @brief   学历认证
//     */
//    public function actionAuthdegree() {
//        $arrReq = $this->getRequestParams();
//        $education = new Education();
//        $talentinfo = new Talentinfo();
//        $education->load($arrReq, '');
//        $model = $education->getEducationByLast($this->userId);
//        if (empty($model)) {
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['DEGREE_IS_EMPTY'], \Yii::$app->params['ErrMsg']['DEGREE_IS_EMPTY']);
//        }
//        if (Education::authEducation($model)) {
//            $arrRes = ['degree' => $model->degree];
//        }
//        if ($talentinfo->saveMaxDegree($this->userId, $model->degree)) {
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $arrRes);
//        } else {
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
//        }
//    }
    public function actionQrcode()
    {
        return QrCode::png('http://www.yii-china.com');    //调用二维码生成方法
    }
//    /**
//     * @brief 获取人才展示列表
//     */
//    public function actionGetlist() {
//        $arrReq = $this->getRequestParams();
//        $validator = new ValidCheck();
//        if ($validator->load($arrReq, '') && $validator->validate()) {
//            $talentlist = new Talentinfo();
//            $model = $talentlist->getTalentList($validator->pn, $validator->rn, $validator->type);
//            foreach ($model as $k => $v) {
//                $model[$k]['tlevel'] = 'A类人才';
//                $model[$k]['job'] = '校长';
//                $model[$k]['company'] = '清华大学';
//            }
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
//        } else {
//            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
//        }
//    }
//    /**
//     * @brief 获取类别列表
//     *
//     */
//    public function actionGetcategory()
//    {
//        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.talentShowType']);
//    }
    /**
     * @brief 获取政治面貌列表
     *
     */
    public function actionGetpolvisage()
    {
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], \Yii::$app->params['talent.polvisage']);
    }
    /**
     * @brief 获取人才活跃指数
     */
    public function actionActiveindex() {
        $model = Talentactiveindex::find()->select(['id', 'county', 'onlinecnt', 'incnt', 'url'])->all();;
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
    }
    /**
     * @brief 伯乐奖申请
     */
    public function actionBoleawardapply() {
        $arrReq = $this->getRequestParams();
        if (!empty($arrReq['filesigns']) && is_array($arrReq['filesigns'])) {
            BoleRewardApply::savefiles($this->userId, $arrReq['filesigns']);
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
    }
}