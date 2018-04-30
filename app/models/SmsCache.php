<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Verifycodecache;

/**
 * sms的cache存储
 */
class SmsCache extends Model
{
    public $mobile;
    //
    public $cacheKey=null;
    public $cacheValue=null;

    /**
     * @return
     */
    public function rules()
    {
        return [
            [['mobile'], 'trim'],
            [['mobile'], 'required'],

            [['mobile'], 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]{9}$/'],
//            [['mobile'], 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号已被注册！'],
        ];
    }
    /**
     * @return
     */
    public function attributeLabels()
    {
        return [
            'mobile' => '手机号',
        ];
    }
    /**
     * @brief 设置缓存手机验证码的redis的key
     */
    public function setCacheKey() {
        $this->cacheKey = \Yii::$app->params['MobileRedisKeyPrefix'] . $this->mobile;
    }
    /**
     * @brief 从redis中获取短信验证码信息
     */
    public function getCache() {
        $this->setCacheKey();
        $redis = \Yii::$app->redis;
//        $val = $redis->get($this->cacheKey);
//        if ($val) {
//            $this->cacheValue = json_decode($val, true);
//        }
        $this->cacheValue = $this->getSmsVerifyCode($this->cacheKey);
        return $this->cacheValue;
    }
    /**
     * @brief 从redis中获取短信验证码信息,redis目前在阿里云有问题，先用mysql
     */
    public function getSmsVerifyCode($cachekey) {
        $model = Verifycodecache::find()->where(['cachekey' => $cachekey])->one();
        $arrRes = array();
        if ($model) {
            $arrRes = array(
                'verifycode' => $model->verificode,
                'timeout' => $model->timeout,
            );
        }
        return $arrRes;
    }
    /**
     * @brief 从redis中存储短信验证码信息,redis目前在阿里云有问题，先用mysql
     */
    public function setSmsVerifyCode($cachekey, $arrValue) {
        $model = new Verifycodecache();
        $model->saveSmsVerifyCode($cachekey, $arrValue);
        return true;
    }
    /**
     * @brief 向redis中存储短信验证码信息
     */
    public function setCache($verifyCode)
    {
        //$redis = \Yii::$app->redis;
        $this->setCacheKey();
        $value = array(
            'verifycode' => $verifyCode,
            'timeout' => time() + \Yii::$app->params['SignupSmsCacheValidateTime'],
        );

        if (!empty($this->mobile)) {
            $res = $this->setSmsVerifyCode($this->cacheKey, $value);
            //$res = $redis->set($this->cacheKey,json_encode($value));
            if ($res) {
                return true;
            }
        }
        return false;
    }
}
