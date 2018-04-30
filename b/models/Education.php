<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $school
 * @property string $institute
 * @property string $degree
 * @property string $graduation_year
 * @property string $certificate
 * @property string $diploma
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 教育经历信息
 */

class Education extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%education}}';
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
            'school' => '学校',
            'institute' => '学院',
            'degree' => '学历',
            'graduation_year' => '毕业年份',
            'certificate' => '学位证书',
            'diploma' => '学历证书',
            'vcode' => '学信网查询',
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
    public function getData($id) {
        $this->user_id = $id;
        $education = Education::findInfoByUid($this->user_id);
        return $education;
    }
    /**
     *
     * @return
     */
    public static function getInfo($id) {
        $education = Education::find()->where(['user_id' => $id])
            ->select(['certificate', 'diploma', 'degree'])->orderBy('graduation_year DESC')->asArray()->one();
        return $education;
    }
}