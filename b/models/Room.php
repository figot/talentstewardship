<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $hotelid
 * @property string $roomtype
 * @property int $price
 * @property int $roomnumber
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  房间信息
 */

class Room extends ActiveRecord
{
    public $hotelname;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%room}}';
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

    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['id' => 'hotelid']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hotelid', 'roomtype', 'price', 'roomnumber', 'status'], 'trim'],
            [['roomtype', 'price', 'roomnumber'], 'required'],
            [['roomnumber'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '房间',
            'hotelid' => '酒店',
            'roomtype' => '类型',
            'price' => '价格',
            'roomnumber' => '房间数量',
            'status' => '审核状态',
        ];
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function search($id)
    {
        $query = Room::find()->where(['hotelid' => $id]);
        $query->joinWith('hotel');
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
                    $this->status = 1;
                }
            }
            return true;
        } else {
            return false;
        }
    }
}