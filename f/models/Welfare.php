<?php

namespace f\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $user_id
 * @property string $title
 * @property string $url
 * @property string $brief
 * @property string $content
 * @property int $treattype
 * @property int $looktype
 * @property int $treatlevel
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Welfare extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%treatment}}';
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
            [['id'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '待遇申请标题',
            'brief' => '待遇简介',
            'content' => '待遇内容',
            'treattype' => '享受类型',
            'looktype' => '查看类型',
            'treatlevel' => '待遇级别',
            'status' => '状态',
        ];
    }
}