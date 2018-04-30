<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $hotelname
 * @property string $area
 * @property string $address
 * @property string $suitper
 * @property int $star
 * @property string $thumbnail
 * @property string $image
 * @property integer $score
 * @property string $content
 * @property double $longitude
 * @property double $latitude
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 酒店信息
 */

class Hotel extends ActiveRecord
{
    public $suitperlist = array();
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotel}}';
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
            [['hotelname', 'area', 'address', 'suitper', 'suitperlist', 'star', 'score', 'longitude', 'latitude', 'thumbnail', 'content', 'status'], 'trim'],
            [['hotelname', 'area', 'address', 'suitper', 'suitperlist', 'star', 'thumbnail'], 'required'],
            [['longitude', 'latitude'], 'double'],
            [['score'], 'number'],
            [['hotelname'], 'unique'],
            [['area'], 'string', 'length' => [1, 10]],
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
                if (empty($this->score)) {
                    $this->score = 0;
                }
                //$this->url = \Yii::$app->params['h5urlprefix'] . 'welfare?id=';
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '房间详情',
            'hotelname' => '酒店名称',
            'area' => '所属区域',
            'address' => '地址',
            'suitper' => '适用人才',
            'suitperlist' => '适用人才',
            'star' => '星级',
            'thumbnail' => '缩略图链接',
            'images' => '酒店图片上传',
            'score' => '得分',
            'longitude' => '经度',
            'latitude' => '纬度',
            'content' => '详细内容',
            'qrurl' => '酒店签到二维码',
            'status' => '审核状态',
        ];
    }
    /**
     * @inheritdoc
     */
    public function afterFind() {
        parent::afterFind();
        $this->suitperlist = explode(',', $this->suitper);
    }

}