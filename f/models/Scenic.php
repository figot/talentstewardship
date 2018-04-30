<?php

namespace f\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $name
 * @property string $area
 * @property string $address
 * @property string $url
 * @property string $thumbnail
 * @property string $content
 * @property double $longitude
 * @property double $latitude
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 景区信息
 */

class Scenic extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%scenic}}';
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
            [['id'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '景区名称',
            'area' => '所属区域',
            'address' => '地址',
            'thumbnail' => '缩略图链接',
            'longitude' => '经度',
            'latitude' => '纬度',
            'url' => '落地页地址',
            'qrurl' => '二维码',
            'content' => '详细内容',
        ];
    }
}