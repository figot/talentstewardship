<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property string $educate
 * @property string $talentlevel
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  学历人才类型配置
 */

class Educationlevelconf extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%educationlevelconf}}';
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
            [['educate', 'talentlevel'], 'trim'],
            [['educate', 'talentlevel'], 'required'],
            ['educate', 'in', 'range' => ['博士后', '博士', '硕士', '本科', '专科', '专科以下']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'educate' => '学历',
            'talentlevel' => '准人才名称配置',
        ];
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function search($id)
    {
        $query = Educationlevelconf::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}