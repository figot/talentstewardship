<?php

namespace app\models;

use app\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * 重置密码
 */
class ResetPasswordForm extends Model
{
    public $password;

    public $passwordrepeat;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('参数错误！');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('未找到需要重置密码的用户！');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'passwordrepeat'], 'required'],
            [['password', 'passwordrepeat'], 'trim'],
            [['password'], 'match', 'pattern' => '/^\S+$/'],
            [['password'], 'string', 'length' => [6, 32]],
            [['passwordrepeat'], 'compare', 'compareAttribute' => 'password', 'message' => '两次密码不一致。']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => '新密码',
            'passwordrepeat' => '密码确认'
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        $user->generatePasswordResetToken();
        $user->generateAccessToken();

        if ($user->save(false)) {
            return $user->attributes['id'];
        }

        return false;
    }
}
