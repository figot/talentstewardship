<?php

namespace b\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 *
 * @property integer $id
 * @property string $department
 * @property int $policytype
 * @property int $status
 * @property string $title
 * @property string $content
 * @property string $url
 * @property string $suit_per
 * @property string $suit_area
 * @property int $release_time
 * @property int $can_share
 * @property string $thumbnail
 * @property int $read_count
 * @property integer $created_at
 * @property integer $updated_at
 */
class Policy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'policy';
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
            [['department', 'policytype', 'status', 'title', 'content', 'suit_per', 'suit_area', 'thumbnail', 'url', 'can_share'], 'trim'],
            [['policytype', 'title', 'content'], 'required'],

            [['policytype', 'can_share'], 'integer'],
            [['title','content', 'thumbnail', 'url' ], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department' => '发布部门',
            'policytype' => '政策类型',
            'title' => '政策标题',
            'content' => '政策内容',
            'url' => '政策内容落地页预览',
            'suit_per' => '适用人群',
            'suit_area' => '适用区域',
            'read_count' => '阅读次数',
            'thumbnail' => '缩略图',
            'can_share' => '是否能够分享',
            'status' => '审核状态',
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
                $this->url = Yii::$app->params['h5urlprefix'] . 'policy?id=';
                $this->release_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
}