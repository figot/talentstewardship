<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property sring $county
 * @property int $onlinecnt
 * @property int $incnt
 * @property int $outcnt
 * @property string $url
 *
 * @brief  人才活跃指数
 */

class Talentactiveindex extends ActiveRecord
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

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'county' => '县市',
            'onlinecnt' => '在线人数',
            'incnt' => '人才流入数',
            'outcnt' => '人才流出数',
            'url' => '落地页链接',
        ];
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function get()
    {
        $activeindex = Talentactiveindex::find()->select(['id', 'county', 'onlinecnt', 'incnt'])->all();

        return $activeindex;
    }
}