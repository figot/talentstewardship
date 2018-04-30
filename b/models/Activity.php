<?php

namespace b\models;

use Yii;

use yii\behaviors\TimestampBehavior;

/**
 *
 * @property integer $id
 * @property string $department
 * @property int $acttype
 * @property string $title
 * @property string $content
 * @property int $activity_time
 * @property string $activity_pos
 * @property int $user_cnt
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
            [['department', 'acttype', 'title', 'content', 'activity_time', 'activity_pos', 'thumbnail'], 'trim'],

            [['acttype'], 'integer'],

            [['department', 'title', 'content', 'activity_time', 'activity_pos', 'thumbnail'], 'string'],
        ];
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
    public function attributeLabels()
    {
        return [
            'department' => '活动组织部门',
            'acttype' => '活动类型',
            'title' => '标题',
            'content' => '内容',
            'activity_time' => '活动时间',
            'activity_pos' => '活动地点',
            'user_cnt' => '报名人数',
            'thumbnail' => '缩略图',
            'status' => '状态',
            'release_time' => '发布时间',
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
                    $this->status = 2;
                }
                $this->url = Yii::$app->params['h5urlprefix'] . 'activity?id=';
                $this->release_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
}