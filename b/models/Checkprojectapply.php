<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property string $projectid
 * @property string $templateid
 * @property string $applystatus
 * @property string $remark
 * @property string $reason
 * @property string $applytime
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Checkprojectapply extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%checkprojectapply}}';
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
            [['applystatus', 'reason', 'remark', 'department'], 'trim'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applystatus' => '申请状态',
            'reason' => '审核意见',
            'remark' => '申请内容',
            'department' => '申请部门',
        ];
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->applystatus = 1;
                $this->applytime = time();
            }
            return true;
        } else {
            return false;
        }
    }
}