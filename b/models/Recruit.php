<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property string $department
 * @property int $status
 * @property string $title
 * @property string $content
 * @property string $job
 * @property string $welfare
 * @property int $company
 * @property string $attibute
 * @property string $salary
 * @property integer $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Recruit extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recruit';
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
            [['title', 'content', 'job', 'welfare', 'company', 'attibute', 'salary', 'status'], 'trim'],

            [['title', 'content', 'job', 'welfare', 'company', 'attibute', 'salary'], 'required'],

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
                $this->release_time = time();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department' => '招聘信息发布部门',
            'status' => '状态',
            'title' => '招聘标题',
            'content' => '招聘内容',
            'job' => '招聘职位',
            'welfare' => '福利',
            'company' => '招聘单位',
            'attibute' => '单位性质',
            'salary' => '薪资',
            'release_time' => '发布时间',
        ];
    }
}