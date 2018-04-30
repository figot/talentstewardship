<?php
namespace app\models;
use Yii;
use yii\base\Model;

/**
 * 验证码登录
 */
class VerifycodeLogin extends Model
{
    public $mobile;
    public $verify_code;
    private $_user = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'verify_code'], 'trim'],
            [['mobile', 'verify_code'], 'required'],

            [['mobile'], 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]{9}$/'],

            [['verify_code'], 'string', 'length' => 6],
        ];
    }
    /**
     * @brief
     */
    public function signup()
    {
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->mobile = $this->mobile;
        $user->uuid = uniqid() . time();
        $user->setPassword(md5(time() . $this->verify_code));
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->generatePasswordResetToken();

        if (!$user->save(false)) {
            throw new \Exception();
        }
        return $user;
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
    /**
     *
     * @return User|null
     */
    public function findUser()
    {
        if ($this->validate()) {
            if ($this->_user === false) {
                $this->_user = User::findByMobile($this->mobile);
            }
            return $this->_user;
        }
        return false;
    }
}