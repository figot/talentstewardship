<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $projectid
 * @property string $isrequired
 * @property string $filetemplateurl
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  项目申报模板
 */

class Projecttemplate extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%projecttemplate}}';
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
            [['id', 'projectid', 'isrequired', 'filetemplateurl', 'templatename'], 'trim'],

            [['isrequired'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '项目申报文件模板',
            'projectid' => '项目',
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
        $query = Projecttemplate::find()->where(['projectid' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}