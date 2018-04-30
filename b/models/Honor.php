<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $year
 * @property string $certificate
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 人才认证，个人荣誉信息
 */

class Honor extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%honor}}';
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '人才名称',
            'year' => '评选年份',
            'certificate' => '证书',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function findInfoByUid($id)
    {
        return static::findAll(['user_id' => $id, 'status' => 1]);
    }
    /**
     * @return
     */
    public function getData($id)
    {
        $this->user_id = $id;
        $honor = Honor::findInfoByUid($this->user_id);
        return $honor;
    }
}