<?php

namespace b\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 *
 * @property integer $id
 * @property int $ptype
 * @property int $status
 * @property string $title
 * @property string $content
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ptype','title', 'content', 'url', 'status', 'jumpurl', 'department', 'brief'], 'trim'],
            [['ptype', 'title', 'content', 'department'], 'required'],

            [['ptype'], 'integer'],
            [['title','content', 'url' ], 'string'],
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
            'ptype' => '申报通知类型',
            'status' => '状态',
            'title' => '标题',
            'content' => '内容',
            'release_time' => '发布时间',
            'jumpurl' => '外部跳转链接',
            'department' => '审核部门',
            'brief' => '项目简介',
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
                $this->url = Yii::$app->params['h5urlprefix'] . 'project?id=';
                $this->release_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
}