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
 * @property string $out_trade_no
 * @property string $price
 * @property int $pay_status
 * @property int $hotelcheckstatus
 * @property int $pay_type
 * @property integer $created_at
 * @property integer $updated_at
 *
 */

class Hotelorder extends ActiveRecord
{
    public $hotelname;
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
            [['status', 'hotelcheckstatus'], 'trim'],

        ];
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
            'status' => '申请状态',
            'hotelcheckstatus' => '酒店确认状态',
            'ischkinbeforedate' => '是否18点前入住',
        ];
    }
}