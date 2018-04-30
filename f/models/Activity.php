<?php

namespace f\models;

/**
 *
 * @property integer $id
 * @property string $department
 * @property int $acttype
 * @property string $title
 * @property string $content
 * @property int $activity_time
 * @property string $activity_pos
 * @property int user_cnt
 * @property string $thumbnail
 * @property int $status
 * @property int $read_count
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'trim'],
            [['id', ], 'required'],

            [['id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'content' => '内容',
        ];
    }
}