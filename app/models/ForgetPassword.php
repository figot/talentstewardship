<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * 忘记密码
 */
class ForgetPassword extends Model
{
    public $mobile;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'password'], 'trim'],
            [['mobile', 'password'], 'required'],

            [['mobile'], 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]{9}$/'],

            [['password'], 'match', 'pattern' => '/^\S+$/'],
            [['password'], 'string', 'length' => [6, 32]],
        ];
    }

    /**
     * @brief
     */
    public function attributeLabels()
    {
        return [
            'mobile' => '手机号',
            'password' => '密码'
        ];
    }
    /**
     * @brief
     */
    public function reset()
    {
        $user = User::findByMobile($this->mobile);
        if (empty($user)) {
            return false;
        }
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
