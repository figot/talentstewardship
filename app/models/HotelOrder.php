<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\Hotel;

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
 * @property int $pay_type
 * @property integer $created_at
 * @property integer $updated_at
 *
 */

class HotelOrders extends ActiveRecord
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
    /**
     *
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['access_token' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->status = 1;
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    /**
     * @inheritdoc
     */
    public function saveData($id) {
        $this->user_id = $id;
        $reserve = Reservation::findIdentity($this->id);
        $hotel = Hotel::findOne(['id' => $this->hotelid]);
        if ($hotel === null) {
            return false;
        }
        if ($reserve !== null) {
            $reserve->attributes = $this->attributes;
            if (!$reserve->save(false)) {
                throw new \Exception();
            }
        } else {
            if (!$this->save(false)) {
                throw new \Exception();
            }
        }
        return true;
    }
    /**
     * @inheritdoc
     */
    public function checkin($id) {
        $reserve = Reservation::findIdentity($this->id);
        $hotel = Hotel::findOne(['id' => $this->hotelid]);
        if ($hotel === null) {
            return false;
        }
        if ($reserve !== null) {
            $reserve->attributes = $this->attributes;
            if (!$reserve->save(false)) {
                throw new \Exception();
            }
        } else {
            if (!$this->save(false)) {
                throw new \Exception();
            }
        }
        return true;
    }
    /**
     * @inheritdoc
     */
    public function getData($id)
    {
        $this->user_id = $id;
        $talent = Reservation::findIdentity($this->user_id);
        return $talent;
    }
}