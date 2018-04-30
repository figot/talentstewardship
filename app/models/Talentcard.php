<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $user_id
 * @property integer $id
 * @property string $tlevel
 * @property int $cardid
 * @property integer $status
 * @property string $good_fields
 *
 */

class Talentcard extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentcard}}';
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
            [['id', 'user_id', 'cardid', 'tlevel', 'status'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cardid' => '人才卡',
            'tlevel' => '等级',
            'status' => '状态',
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
                    $this->status = 2;
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
    public function saveData($id) {
        $this->user_id = $id;
        $this->status = 2;
        $talent = Talentcard::findIdentity($this->user_id);
        if ($talent !== null) {
            $talent->attributes = $this->attributes;
            if (!$talent->save(false)) {
                throw new \Exception();
            }
        } else {
            $this->cardid = $this->user_id + 1000000;
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
    public function getData($id)
    {
        $this->user_id = $id;
        $talent = Talentinfo::findIdentity($this->user_id);
        return $talent;
    }
}