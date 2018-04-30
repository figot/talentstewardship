<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $talentcategoryid
 * @property string $isrequired
 * @property string $filetemplateurl
 * @property string $templatename
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  人才认定模板文件
 */

class Talentfiles extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentfiles}}';
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
            [['id', 'talentcategoryid', 'isrequired', 'filetemplateurl', 'templatename'], 'trim'],

            [['isrequired'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '人才评定文件模板',
            'talentcategoryid' => '人才类别',
            'isrequired' => '是否必填材料',
            'filetemplateurl' => '模板文件上传',
            'templatename' => '模板名称',
        ];
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function search($id)
    {
        $query = Talentfiles::find()->where(['talentcategoryid' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}