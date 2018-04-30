<?php
namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\AdminModel;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property string $companyname
 * @property string $address
 * @property string $email
 * @property string $taxno
 * @property string $business_license
 * @property string $created_at
 * @property string $updated_at
 *
 */

class Company extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';
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
            [['companyname', 'address', 'email', 'mobile', 'business_license', 'status', 'taxno'], 'trim'],
            [['companyname', 'address', 'email', 'mobile', 'business_license', 'taxno'], 'required'],
            ['email', 'email'],
            [['mobile'], 'string', 'length' => [6, 11]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (empty($this->status)) {
                    $this->status = 1;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'companyname' => '公司注册名称',
            'address' => '地址',
            'email' => '邮箱',
            'mobile' => '电话',
            'business_license' => '营业执照',
            'status' => '审核状态',
            'taxno' => '税号',
            'username' => '用户登录帐号',
        ];
    }
    /**
     * @inheritdoc
     */
    public function setStatus() {
        $user = AdminModel::findOne(['id' => $this->user_id, 'status' => 2]);
        if (empty($user)) {
            return false;
        }
        if ($this->status == 2) {
            $user->status = 10;
            if (!$user->save(false)) {
                throw new \Exception();
            }
        }
        if (!$this->save(false)) {
            throw new \Exception();
        }
        return true;
    }
}