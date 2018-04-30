<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\User;

/**
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $source
 * @property string $source_id
 * @property int $source_type
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 第三方登录
 */

class Thirdauth extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%thirdauth}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'appid', 'app_secret', 'openid', 'access_token', 'source_type'], 'trim'],
        ];
    }

    /**
     *
     * @return User|null
     */
    public function getUser($arrInput)
    {
        if ($this->_thirduser === false) {
            $this->_thirduser = Thirdauth::findOne(['source' => $arrInput['appid'], 'source_id' => $arrInput['openid']]);
        }
        return $this->_thirduser;
    }
    /**
     * @brief
     */
    public function signup($arrInput)
    {
        $user = new User();
        $user->mobile = '';
        $user->status = User::STATUS_ACTIVE;
        $user->uuid = uniqid() . time();
        $user->openid = $arrInput['source_type'] . '_' . $arrInput['openid'];
        $user->setPassword(md5($user->uuid));
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->generatePasswordResetToken();

        if (!$user->save(false)) {
            throw new \Exception();
        }
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function saveData() {
        if (!$this->save(false)) {
            throw new \Exception();
        }
        return true;
    }
}