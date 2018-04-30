<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $user_id
 * @property string $company
 * @property string $industry
 * @property string $pos
 * @property string $jobcontent
 * @property string $expstart
 * @property string $expend
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 工作经历信息
 */

class Experience extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%experience}}';
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
            [['id', 'company', 'industry', 'job', 'jobcontent', 'expstart', 'expend'], 'trim'],
            ['expend', 'compare', 'compareAttribute' => 'expstart', 'operator' => '>'],
            [['id'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company' => '单位名称',
            'industry' => '行业',
            'job' => '职位',
            'jobcontent' => '工作内容',
            'expstart' => '开始时间',
            'expend' => '结束时间',
        ];
    }
    /**
     *
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['access_token' => 'user_id']);
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
     * @inheritdoc
     */
    public static function findInfoByUid($id)
    {
        return static::find()->where(['user_id' => $id, 'status' => 1])->orderBy('expstart DESC')->all();
    }
    /**
     * @inheritdoc
     */
    public function saveData($uid, $identity) {
        $this->user_id = $uid;
        $experience = Experience::findOne(['user_id' => $uid, 'id' => $this->id, 'status' => 1]);
        if ($experience !== null) {
            $experience->attributes = $this->attributes;
            if (!$experience->save(false)) {
                throw new \Exception();
            }
        } else {
            if (!$this->save(false)) {
                throw new \Exception();
            }
        }
        return true;
    }
    /**
     *
     * @return
     */
    public function getData($uid)
    {
        $this->user_id = $uid;
        $experience = Experience::findInfoByUid($this->user_id);
        return $experience;
    }
    /**
     *
     * @return
     */
    public function getDataById()
    {
        $experience = Experience::findIdentity($this->id);
        return $experience;
    }
}