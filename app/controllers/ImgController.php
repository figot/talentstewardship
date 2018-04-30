<?php
namespace app\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\Response;
use dosamigos\qrcode\QrCode;
use app\models\Scenicorder;
use app\models\Vipchannelorder;
use app\models\Upload;
use yii\web\UploadedFile;

class ImgController extends ActiveController {
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
            'except' => ['get'],
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
     * @brief 获取图片
     */
    public function actionGet() {
        \Yii::$app->response->format = Response::FORMAT_RAW;
        header('Content-Type: image/png');
        $arrReq = $this->getRequestParams();
        if (!empty($arrReq['sign'])) {
            $filename = \Yii::getAlias('@app') . '/uploads/' . $arrReq['sign'];
            if (file_exists($filename)) {
                echo file_get_contents($filename);
            }
        }
        return;
    }
    /**
     * @brief 上传图片文件, 允许http访问
     */
    public function actionUpload()
    {
        $model = new Upload();

        if (\Yii::$app->request->isPost) {
            //获取单个文件用 getInstanceByName
            $model->single = UploadedFile::getInstanceByName('imagefile');

            $arrRes = $model->upload($this->userId);
            if (!$arrRes) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['UPLOAD_IMG_FAIL'], \Yii::$app->params['ErrMsg']['UPLOAD_IMG_FAIL']);
            }

            unset($model->single);
        }

        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $arrRes);
    }
}