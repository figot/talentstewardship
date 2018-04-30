<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property string $name
 * @property string $category
 * @property string $iconurl
 * @property string $url
 * @property string $appurl
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  其他服务
 */

class Otherservice extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%otherservice}}';
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
            [['name', 'category', 'iconurl', 'url', 'appurl'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '服务名称',
            'category' => '类别',
            'iconurl' => '图标地址',
            'url' => '跳转地址',
            'appurl' => 'app跳转地址',
        ];
    }
    /**
     *
     * @return
     */
    public function search()
    {
        $query = Otherservice::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (empty($this->status)) {
                    $this->status = 2;
                }
            }
            return true;
        } else {
            return false;
        }
    }
}