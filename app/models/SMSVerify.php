<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Verifycodecache;

class SMSVerify extends Model
{
    public $verifycode;
    public $mobile;
    public $cache;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'verifycode'], 'trim'],
            [['mobile', 'verifycode'], 'required'],

            [['verifycode'], 'string', 'length' => 6],
            [['mobile'], 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]{9}$/'],
        ];
    }
    /**
     * @return
     */
    public function getCache() {
        $cacheKey = $this->setCacheKey();
        $this->cache = $this->getSmsVerifyCode($cacheKey);
//        $redis = \Yii::$app->redis;
//        $val = $redis->get($cacheKey);
//        if (!empty($val)) {
//            $this->cache = json_decode($val, true);
//        }
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
     * @return
     */
    public function setCache() {
        $cacheKey = $this->setCacheKey();
        $redis = \Yii::$app->redis;
        $value = array(
            'verifycode' => $this->verifycode,
            'timeout' => time(),
        );

        $res = $redis->set($cacheKey,json_encode($value));
        if ($res) {
            return true;
        }
    }
    /**
     * @brief 设置缓存手机验证码的redis的key
     */
    public function setCacheKey() {
        $cachekey = \Yii::$app->params['MobileRedisKeyPrefix'] . $this->mobile;
        return $cachekey;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifycode' => '手机验证码',
        ];
    }

    /**
     *
     * @return
     */
    public function verify()
    {
        $this->getCache();
        if (empty($this->cache['verifycode']) || empty($this->cache['timeout'])
            || $this->cache['timeout'] < time()) {
            return false;
        }
        if ($this->cache['verifycode'] == $this->verifycode) {
            return true;
        }
        return false;
    }
}