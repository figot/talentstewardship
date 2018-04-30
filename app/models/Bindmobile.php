<?php

namespace app\models;

use Yii;
use yii\base\Model;
/**
 * 绑定手机号
 */
class Bindmobile extends Model
{
    public $mobile;
    public $password;
    public $access_token;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'password', 'access_token'], 'trim'],
            [['mobile', 'password', 'access_token'], 'required'],

            [['mobile'], 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]{9}$/'],

            [['password'], 'match', 'pattern' => '/^\S+$/'],
            [['password'], 'string', 'length' => [6, 32]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mobile' => '手机号',
            'password' => '密码',
            'access_token' => 'token',
        ];
    }
    /**
     * @brief
     */
    public function bindmobile()
    {
        $user = User::findIdentityByAccessToken($this->access_token);
        if (empty($user)) {
            return false;
        }
        $user->mobile = $this->mobile;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->generatePasswordResetToken();

        if (!$user->save(false)) {
            throw new \Exception();
        }
        return $user;
    }
}