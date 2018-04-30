<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $treatid
 * @property string $isrequired
 * @property string $filetemplateurl
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  待遇申报模板
 */

class Welfaretemplate extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%treattemplate}}';
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
            [['id', 'treatid', 'isrequired', 'filetemplateurl', 'templatename'], 'trim'],

            [['isrequired'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '待遇申请文件模板',
            'projectid' => '项目',
            'isrequired' => '是否必填材料',
            'filetemplateurl' => '模板文件上传',
            'templatename' => '文件模板',
        ];
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function search($id)
    {
        $query = Welfaretemplate::find()->where(['treatid' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}