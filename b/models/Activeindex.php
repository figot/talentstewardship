<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $county
 * @property int $onlinecnt
 * @property int $incnt
 * @property int $outcnt
 * @property string $url
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  人才活跃指数
 */

class Activeindex extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentactiveindex}}';
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
            [['county', 'onlinecnt', 'incnt', 'outcnt'], 'trim'],
            [['county'], 'required'],
            [['county'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'county' => '区域',
            'onlinecnt' => '在线活跃人数',
            'incnt' => '人才流入数',
            'outcnt' => '人才流出数',
        ];
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function search($id)
    {
        $query = Activeindex::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}