<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use b\models\TalentCategory;

/**
 *
 * @property integer $user_id
 * @property string $mobile
 * @property string $user_name
 * @property string $gender
 * @property string $id_number
 * @property string $pol_visage
 * @property string $address
 * @property string $email
 * @property string $qq
 * @property string $wechat
 * @property string $brief
 * @property string $portrait
 * @property integer $status
 * @property string $good_fields
 * @property string $category
 * @property int $isshow
 *
 */

class Talent extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentinfo}}';
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
            [['mobile', 'user_name', 'gender', 'id_number', 'pol_visage', 'address', 'email', 'qq', 'wechat', 'brief', 'portrait', 'good_fields', 'isshow', 'category'], 'trim'],
            [['mobile'], 'required'],
            ['email', 'email'],
            [['mobile'], 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]{9}$/'],
            [['id_number'], 'match', 'pattern' => '/(^\d{15}$)|(^\d{17}([0-9]|X)$)/'],
            ['qq', 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_name' => '人才名称',
            'gender' => '性别',
            'id_number' => '身份证号',
            'pol_visage' => '政治面貌',
            'mobile' => '手机号',
            'address' => '地址',
            'email' => '邮箱',
            'qq' => 'qq',
            'wechat' => '微信',
            'brief' => '个人简介',
            'good_fields' => '擅长领域',
            'isshow' => '是否展示到APP',
            'category' => '人才类别',
            'authstatus' => '认证状态',
            'maxdegree' => '最高学历',
        ];
    }

    public function getTalentcategory()
    {
        return $this->hasOne(TalentCategory::className(), ['id' => 'category']);
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
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => 1]);
    }
    /**
     *
     * @return
     */
    public function getData($id)
    {
        $talent = Talent::findIdentity($id);
        return $talent;
    }
    /**
     *
     * @return
     */
    public static function getDataByUid($uid)
    {
        $talent = static::findOne(['user_id' => $uid]);
        return $talent;
    }
    /**
     * @inheritdoc
     */
    public function saveData($id) {
        $this->user_id = $id;
        $talent = Talent::findIdentity($this->user_id);
        if ($talent !== null) {
            $talent->attributes = $this->attributes;
            if (!$talent->save(false)) {
                throw new \Exception();
            }
        } else {
            if (!$this->save(false)) {
                throw new \Exception();
            }
        }
        return true;
    }
}