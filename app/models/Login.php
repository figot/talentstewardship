<?php
namespace app\models;
use Yii;
use yii\base\Model;
/**
 * Login
 */
class Login extends Model
{
    public $mobile;
    public $password;
    private $_user = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }
    /**
     *
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
    /**
     * @brief 登录
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return \Yii::$app->user->login($this->getUser());
        } else {
            return false;
        }
    }
    /**
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByMobile($this->mobile);
        }
        return $this->_user;
    }
}