<?php

namespace app\models;

/**
 *
 * @property integer $id
 * @property int $verificode
 * @property string $cachekey
 * @property string $timeout
 * @property integer $created_at
 * @property integer $updated_at
 */
class Verifycodecache extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verifycodecache';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }
    /**
     * @brief 保存sms验证码
     */
    public function saveSmsVerifyCode($cachekey, $arrValue) {
        $mobile = Verifycodecache::findOne(['cachekey' => $cachekey]);
        if ($mobile !== null) {
            $mobile->cachekey = $cachekey;
            $mobile->verificode = $arrValue['verifycode'];
            $mobile->timeout = $arrValue['timeout'];
            if (!$mobile->save(false)) {
                throw new \Exception();
            }
        } else {
            $this->cachekey = $cachekey;
            $this->verificode = $arrValue['verifycode'];
            $this->timeout = $arrValue['timeout'];
            if (!$this->save(false)) {
                throw new \Exception();
            }
        }
        return true;
    }
}