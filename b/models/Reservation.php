<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $hotelid
 * @property string $user_name
 * @property string $id_number
 * @property string $chkindt
 * @property string $chkoutdt
 * @property string $startdt
 * @property string $enddt
 * @property integer $rooms
 * @property string $roomtype
 * @property bool $ischkinbeforedate
 * @property integer $created_at
 * @property integer $updated_at
 *
 */

class Reservation extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reservation}}';
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
            [['hotelid', 'user_name', 'id_number', 'chkindt', 'chkoutdt', 'startdt', 'enddt', 'rooms', 'roomtype', 'ischkinbeforedate'], 'trim'],

            [['hotelid', 'user_name', 'id_number', 'startdt', 'enddt', 'rooms', 'roomtype', 'ischkinbeforedate'], 'required'],

            [['ischkinbeforedate'], 'in', 'range' => [0, 1]],
            [['roomtype'], 'in', 'range' => ['单间', '标间',]],
            [['rooms'], 'number'],
            [['id_number'], 'match', 'pattern' => '/(^\d{15}$)|(^\d{17}([0-9]|X)$)/'],

        ];
    }
    /**
     * @inheritdoc
     */
    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['id' => 'hotelid']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_name' => '姓名',
            'id_number' => '身份证号',
            'chkindt' => '签入',
            'chkoutdt' => '签出',
            'startdt' => '开始时间',
            'enddt' => '结束时间',
            'rooms' => '房间数',
            'roomtype' => '房间类型',
            'ischkinbeforedate' => '是否18点前入住',
        ];
    }
}