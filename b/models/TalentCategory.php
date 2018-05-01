<?php
namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property string $talentlevel
 * @property string $talentcondition
 * @property string $brief
 * @property int $isshow
 * @property string $content
 * @property integer $status
 *
 */

class TalentCategory extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentcategory}}';
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
            [['id', 'talentlevel', 'talentcondition', 'status', 'educate', 'authmethod'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'talentlevel' => '人才分类的级别名称',
            'talentcondition' => '人才申请条件',
            'brief' => '简介',
            'content' => '详细内容',
            'isshow' => '是否展示',
            'status' => '审核状态',
            'educate' => '学位',
            'authmethod' => '认证方式',
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
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public static function getLevels() {
        $levelconf = array();
        $level = TalentCategory::find()->where(['status' => 2])->select(['talentlevel'])->asArray()->all();
        foreach ($level as $key => $value) {
            $levelconf = array_merge($levelconf, array($value['talentlevel'] => $value['talentlevel']));
        }
        return $levelconf;
    }
}