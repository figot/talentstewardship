<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property string $department
 * @property string $applystatus
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Needs extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'needs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'department', 'subdepart', 'applystatus', 'reason'], 'trim'],
            [['title', 'content', 'subdepart', 'department'], 'required'],

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
            'title' => '标题',
            'content' => '个人需求',
            'department' => '一级部门',
            'subdepart' => '二级部门',
            'applystatus' => '申请状态',
            'reason' => '审核意见',
        ];
    }
}