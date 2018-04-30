<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property int $status
 * @property int $atype
 * @property string $tlevel
 * @property string $title
 * @property string $content
 * @property string $job
 * @property int $company
 * @property string $applier_name
 * @property string $portrait
 * @property integer $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Applier extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applier';
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
            [['applier_name', 'status', 'job', 'atype', 'tlevel', 'job', 'company', 'title', 'content', 'good_fields'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'atype' => '自荐、荐才',
            'applier_name' => '应聘人才',
            'tlevel' => '人才类别',
            'job' => '曾任职位',
            'company' => '曾任单位',
            'title' => '应聘标题',
            'content' => '应聘内容',
            'portrait' => '招聘单位',
            'release_time' => '发布时间',
        ];
    }
}