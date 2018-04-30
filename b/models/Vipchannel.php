<?php

namespace b\models;

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
 * @brief vip通道信息
 */

class Vipchannel extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vipchannel}}';
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
            [['name', 'area', 'address', 'longitude', 'latitude', 'thumbnail', 'content', 'status'], 'trim'],
            [['longitude', 'latitude'], 'double'],
            [['area'], 'string', 'length' => [1, 10]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'vip通道名称',
            'area' => '所属区域',
            'address' => '地址',
            'thumbnail' => '缩略图链接',
            'longitude' => '经度',
            'latitude' => '纬度',
            'url' => '落地页地址',
            'qrurl' => 'vip通道二维码',
            'content' => '详细内容',
            'status' => '状态',
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
                $this->url = \Yii::$app->params['h5urlprefix'] . 'vipchannel?id=';
            }
            return true;
        } else {
            return false;
        }
    }
}