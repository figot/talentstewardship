<?php
namespace app\controllers;

use app\models\Bindmobile;
use app\models\ForgetPassword;
use app\models\Login;
use app\models\Signup;
use app\models\Thirdauth;
use app\models\SMSVerify;
use app\models\SmsCache;
use app\models\User;
use app\models\Verifycodecache;
use app\models\VerifycodeLogin;
use dosamigos\qrcode\formats\Sms;
use yii\rest\Controller;
use yii\web\Response;
use app\models\ResetPasswordForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use app\models\PasswordResetMobileRequestForm;
use linslin\yii2\curl;

class UserController extends Controller
{
    /**
     * @brief
     * @return
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = '';
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
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
//            'auth' => [
//                'class' => 'yii\authclient\AuthAction',
//                'successCallback' => [$this, 'onAuthSuccess'],
//            ],
        ];
    }
    /**
     * @brief 用户登录
     * @return
     */
    public function actionLogin()
    {
        $arrReq = $this->getRequestParams();
        if (!empty($arrReq['verify_code'])) {
            $arrReq['verifycode'] = $arrReq['verify_code'];
            $verifyModel = new SMSVerify();
//            if ($verifyModel->load($arrReq, '') && $verifyModel->validate()) {
//                if (!$verifyModel->verify()) {
//                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['VERIFYCODE_ERROR'], \Yii::$app->params['ErrMsg']['VERIFYCODE_ERROR']);
//                }
//            } else {
//                return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
//            }

            $model = new VerifycodeLogin();
            $model->load($arrReq, '');
            $user = $model->findUser();
            if (!empty($user)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $user);
            }
//            if ($user = $model->signup()) {
//                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $user);
//            }
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['LOGIN_FAIL'], \Yii::$app->params['ErrMsg']['LOGIN_FAIL']);
        } else {
            $model = new Login();
            $model->load($arrReq, '');

            if ($model->login()) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model->getUser());
            } else {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['LOGIN_FAIL'], \Yii::$app->params['ErrMsg']['LOGIN_FAIL']);
            }
        }
    }
    /**
     * @brief 自动登录
     * @return
     */
    public function actionAutologin()
    {
        $arrReq = $this->getRequestParams();
        $model = User::findOne(['access_token' => $arrReq['access_token'], 'id' => $arrReq['id'], 'status' => 1]);

        if ($model) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['LOGIN_FAIL'], \Yii::$app->params['ErrMsg']['LOGIN_FAIL']);
        }
    }
    /**
     * @brief 用户注册
     * @return
     */
    public function actionSignup()
    {
        $arrReq = $this->getRequestParams();
        $verifyModel = new SMSVerify();
        if ($verifyModel->load($arrReq, '') && $verifyModel->validate()) {
            if (!$verifyModel->verify()) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['VERIFYCODE_ERROR'], \Yii::$app->params['ErrMsg']['VERIFYCODE_ERROR']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }

        $signup = new Signup();
        $signup->load($arrReq, '');
        if (!$signup->validate()) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['MOBILE_FAIL'], \Yii::$app->params['ErrMsg']['MOBILE_FAIL']);
        }

        if ($user = $signup->signup()) {
            if (\Yii::$app->user->login($user)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $user);
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SIGNUP_FAIL'], \Yii::$app->params['ErrMsg']['SIGNUP_FAIL']);
    }
    /**
     * @brief 用户退出登录
     * @return
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
    }

    /**
     * @brief 发送短信验证码
     * @return
     */
    public function actionSendsms()
    {
        $message = '';
        $model = new SmsCache();
        $arrRes = $this->getRequestParams();
        if ($model->load($arrRes, '') && $model->validate()) {
            $cache = $model->getCache();
            if (isset($cache['timeout']) && $cache['timeout'] > time() + \Yii::$app->params['SmsTimeout']) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SMS_REQUEST_TOO_MANY'], \Yii::$app->params['ErrMsg']['SMS_REQUEST_TOO_MANY']);
            } else {
                $verifyCode = (string) mt_rand(100000, 999999);

                $content = array(
                    'code' => $verifyCode,
                );
                $content = json_encode($content);
                $sent = \Yii::$app->smser->send($model->mobile, $content);
                if ($sent) {
                    $model->setCache($verifyCode);
                    \Yii::info("用户注册发送验证码成功！手机号：{$model->mobile}");
                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS']);
                } else {
                    return $this->_buildReturn(\Yii::$app->params['ErrCode']['SMS_REQUEST_FAIL'], \Yii::$app->params['ErrMsg']['SMS_REQUEST_FAIL']);
                }
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['MOBILE_FAIL'], \Yii::$app->params['ErrMsg']['MOBILE_FAIL']);
        }
    }
    /**
     * @brief 重置密码
     * @return
     */
    public function actionResetpassword()
    {
        $arrReq = $this->getRequestParams();
        try {
            $model = new ResetPasswordForm($arrReq['reset_token']);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load($arrReq, '') && $model->validate()) {
            $id = $model->resetPassword();
            if (!empty($id)) {
                $data = User::find()->where(['id' => $id])->asArray()->one();
            }
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $data);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 忘记密码
     * @return
     */
    public function actionForgetpassword()
    {
        $arrReq = $this->getRequestParams();
        if (!empty($arrReq['verify_code'])) {
            $arrReq['verifycode'] = $arrReq['verify_code'];
        }
        $verifyModel = new SMSVerify();
        if ($verifyModel->load($arrReq, '') && $verifyModel->validate()) {
            if (!$verifyModel->verify()) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['VERIFYCODE_ERROR'], \Yii::$app->params['ErrMsg']['VERIFYCODE_ERROR']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }

        $model = new ForgetPassword();

        if ($model->load($arrReq, '') && $model->validate()) {
            $user = $model->reset();
            if (empty($user)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
            } else {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $user);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 密码找回
     * @return
     */
    public function actionRequestPasswordReset($type = 'sms', $step = '1')
    {
        $arrReq = $this->getRequestParams();
        if ($arrReq['type'] === 1) {
            if ($step !== '2') {
                $model = new PasswordResetMobileRequestForm();
                if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                    if ($model->sendMsg()) {
                        $session['passwordResetTimeout'] = time() + 900; // 15 minutes
                        $session['passwordResetMobile'] = $model->mobile;

                        return $this->redirect(['request-password-reset', 'type' => $type, 'step' => '2']);
                    } else {
                        $session->setFlash('smsFailure', '对不起，验证码发送失败。');
                    }
                }
            } elseif (isset($session['passwordResetTimeout']) && $session['passwordResetTimeout'] >= time()) {
                $model = new PasswordResetVerifyForm();
                $model->load(Yii::$app->request->post());

                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }

                if (Yii::$app->request->isPost && $model->validate()) {

                    if ($model->generateToken()) {
                        $model->clearSession();
                        return $this->redirect(['reset-password', 'token' => $model->user->password_reset_token]);
                    } else {
                        $session->setFlash('resetErr', '操作失败，请稍后再试！');
                    }
                }
            } else {
                $session->setFlash('resetAgain', '对不起，请您重新开始一次。');
                return $this->redirect(['request-password-reset', 'type' => $type]);
            }

        } else {
            throw new BadRequestHttpException('参数错误！');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
            'type' => $type,
            'step' => $step
        ]);
    }
    /**
     * @brief 用户第三方登录
     * @return
     */
    public function actionThirdlogin() {
        $arrReq = $this->getRequestParams();
        $ret = $this->sendRequestCheckLogin($arrReq);
        if (empty($ret)) {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['THIRD_LOGIN_CHECK_FAIL'], \Yii::$app->params['ErrMsg']['THIRD_LOGIN_CHECK_FAIL']);
        }
        $model = Thirdauth::findOne(['appid' => $ret['appid'], 'openid' => $ret['openid']]);
        if ($model) {
            $user = User::findIdentity(['id' => $model->user_id]);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $user);
        } else {
            $thirdauth = New Thirdauth();
            $user = $thirdauth->signup($ret);
            if ($user) {
                $ret['user_id'] = $user->id;
                if ($thirdauth->load($ret, '') && $thirdauth->validate()) {
                    if ($thirdauth->saveData()) {
                        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $user);
                    }
                }
            }
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['THIRD_LOGIN_FAIL'], \Yii::$app->params['ErrMsg']['THIRD_LOGIN_FAIL']);
    }
    /**
     * @brief 用户第三方登录绑定手机号
     * @return
     */
    public function actionBindmobile() {
        $arrReq = $this->getRequestParams();
        if (!empty($arrReq['verify_code'])) {
            $arrReq['verifycode'] = $arrReq['verify_code'];
        }
        $verifyModel = new SMSVerify();
        if ($verifyModel->load($arrReq, '') && $verifyModel->validate()) {
            if (!$verifyModel->verify()) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['VERIFYCODE_ERROR'], \Yii::$app->params['ErrMsg']['VERIFYCODE_ERROR']);
            }
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }

        $binding = new Bindmobile();
        if ($binding->load($arrReq, '') && $binding->validate()) {
            $model = User::findByMobile($arrReq['mobile']);
            if ($model) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['BIND_MOBILE_FAIL'], \Yii::$app->params['ErrMsg']['BIND_MOBILE_FAIL']);
            }
            $user = $binding->bindmobile();
            if (empty($user)) {
                return $this->_buildReturn(\Yii::$app->params['ErrCode']['UN_REGISTER_USER'], \Yii::$app->params['ErrMsg']['UN_REGISTER_USER']);
            }
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $user);
        }
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
    }
    /**
     * @brief 用户第三方登录校验
     * @return
     */
    public function sendRequestCheckLogin($arrInput) {
        if ($arrInput['type'] == \Yii::$app->params['weixinlogin']) {
            $ret = self::isWeixinTokenValid($arrInput);
        }
        if ($arrInput['type'] == \Yii::$app->params['qqlogin']) {
            $ret = self::isQqTokenValid($arrInput);
        }
        if ($arrInput['type'] == \Yii::$app->params['weibologin']) {
            $ret = self::isWeiboTokenValid($arrInput);
        }
        return $ret;
    }
    /**
     * @brief 微信校验,检查授权凭证是否有效
     * @return
     */
    public function isWeixinTokenValid($arrInput) {
        $arrRes = array();
        $tokenUrl = 'https://api.weixin.qq.com/sns/auth';
        $curl = new curl\Curl();
        $response = $curl->setGetParams([
            'access_token' => $arrInput['access_token'],
            'openid' => $arrInput['openid'],
        ])->get($tokenUrl);
        $arrRet = json_decode($response, true);
        if (isset($arrRet['errcode']) && $arrRet['errcode'] === 0) {
            $arrRes = array(
                'appid' => $arrInput['appid'],
                'app_secret' => $arrInput['app_secret'],
                'access_token' => $arrInput['access_token'],
                'openid' => $arrInput['openid'],
                'source_type' => 1,
            );
            return $arrRes;
        } else {
            return false;
        }
    }
    /**
     * @brief qq校验,检查授权凭证是否有效
     * @return
     */
    public function isQqTokenValid($arrInput) {
        $arrRes = array();
        $tokenUrl = 'https://graph.qq.com/oauth2.0/me';
        $curl = new curl\Curl();
        $response = $curl->setGetParams([
            'access_token' => $arrInput['access_token'],
        ])->get($tokenUrl);
        if (!empty($response)) {
            if (strpos($response, "callback(") === 0) {
                $count = 0;
                $jsonData = preg_replace('/^callback\(\s*(\\{.*\\})\s*\);$/is', '\1', $response, 1, $count);
            }
        }
        $arrRet = json_decode($jsonData, true);
        if (isset($arrRet['client_id']) && $arrRet['client_id'] === $arrInput['appid']) {
            $arrRes = array(
                'appid' => $arrInput['appid'],
                'app_secret' => $arrInput['app_secret'],
                'access_token' => $arrInput['access_token'],
                'openid' => $arrInput['openid'],
                'source_type' => 2,
            );
            return $arrRes;
        } else {
            return false;
        }
    }
    /**
     * @brief 微博校验,检查授权凭证是否有效
     * @return
     */
    public function isWeiboTokenValid($arrInput) {
        $arrRes = array();
        $tokenUrl = 'https://api.weibo.com/oauth2/get_token_info';
        $curl = new curl\Curl();
        $response = $curl->setPostParams([
            'access_token' => $arrInput['access_token'],
        ])->post($tokenUrl);
        $arrRet = json_decode($response, true);
        if (isset($arrRet['appkey']) && $arrRet['appkey'] == $arrInput['appid']) {
            $arrRes = array(
                'appid' => $arrInput['appid'],
                'app_secret' => $arrRet['appkey'],
                'access_token' => $arrInput['access_token'],
                'openid' => $arrRet['uid'],
                'source_type' => 3,
            );
            return $arrRes;
        } else {
            return false;
        }
    }
}
