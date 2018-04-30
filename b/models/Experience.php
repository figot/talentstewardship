<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $user_id
 * @property string $company
 * @property string $industry
 * @property string $pos
 * @property string $jobcontent
 * @property string $expstart
 * @property string $expend
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 工作经历信息
 */

class Experience extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%experience}}';
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
            'company' => '单位名称',
            'industry' => '行业',
            'pos' => '职位',
            'jobcontent' => '工作内容',
            'expstart' => '开始时间',
            'expend' => '结束时间',
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
     *
     * @return
     */
    public function getData($uid)
    {
        $this->user_id = $uid;
        $experience = Experience::findInfoByUid($this->user_id);
        return $experience;
    }
}