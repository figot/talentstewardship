<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\Hotel;
use yii\data\Pagination;

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
                $this->out_trade_no = md5(uniqid(\Yii::$app->request->userIP, true));
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
    public static function findTradeorder($id)
    {
        return static::findOne(['out_trade_no' => $id]);
    }
    /**
     * @inheritdoc
     */
    public function saveData($id) {
        $this->user_id = $id;
        $hotel = Hotel::findOne(['id' => $this->hotelid]);
        $roominfo = Room::findOne(['hotelid' => $this->hotelid, 'roomtype' => \Yii::$app->params['talent.hotel.roomtypename'][$this->roomtype]]);
        if (empty($roominfo)) {
            return false;
        }
        $this->price = $roominfo->price * intval($this->rooms);
        if ($hotel === null) {
            return false;
        }
        if (!$this->save(false)) {
            throw new \Exception();
        }
        return $this;
    }
    /**
     * @inheritdoc
     */
    public function cancell($id, $uid) {
        $reserve = Reservation::findTradeorder($id);
        if ($reserve->user_id != $uid) {
            return false;
        }
        $hotel = Hotel::findOne(['id' => $reserve->hotelid]);
        if ($hotel === null) {
            return false;
        }
        if ($reserve !== null) {
            $reserve->status = 4;
            if (!$reserve->save(false)) {
                throw new \Exception();
            }
            return $reserve;
        }
        return false;
    }
    /**
     * @inheritdoc
     */
    public static function checkin($id, $uid) {
        $reserve = Reservation::findIdentity($id);
        if ($reserve->user_id != $uid) {
            return false;
        }
        $hotel = Hotel::findOne(['id' => $reserve->hotelid]);
        if ($hotel === null) {
            return false;
        }
        if ($reserve !== null) {
            $reserve->status = 2;
            if (!$reserve->save(false)) {
                throw new \Exception();
            }
            return $reserve;
        }
        return false;
    }
    /**
     * @inheritdoc
     */
    public static function checkout($id, $uid) {
        $reserve = Reservation::findIdentity($id);
        if ($reserve->user_id != $uid) {
            return false;
        }
        $hotel = Hotel::findOne(['id' => $reserve->hotelid]);
        if ($hotel === null) {
            return false;
        }
        if ($reserve !== null) {
            $reserve->status = 3;
            if (!$reserve->save(false)) {
                throw new \Exception();
            }
            return $reserve;
        }
        return false;
    }
    /**
     * @inheritdoc
     */
    public function pay() {
        $this->pay_status = 2;
        $this->pay_type = 2;
        if (!$this->save(false)) {
            throw new \Exception();
        }
        return true;
    }
    /**
     *
     * @return
     */
    public function get($rn, $pn, $type=null)
    {
        $query = Hotel::find()->Where(['suitper' => $this->suitper,])
            ->Where(['like', 'area', $this->area]);

        $count = $query->count();

        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $rn,
        ]);
        $pagination->setPage($pn);

        $model = $query->offset($pagination->offset)
            ->orderBy(['score' => SORT_DESC,])
            ->limit($pagination->limit)
            ->asArray()->all();

        foreach ($model as $key => $value) {
            $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
            $model[$key]['distance'] = intval($key) + 0.1;
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }

    /**
     *
     * @return
     */
    public function getMyOrder($rn, $pn, $uid, $type=null)
    {
        $query = Reservation::find()
            ->Where(['user_id' => $uid,])
            ->select(['startdt', 'enddt', 'rooms', 'roomtype', 'price', 'out_trade_no', 'status', 'pay_status', 'ischkinbeforedate', 'user_id', 'hotelid', 'created_at']);

        $count = $query->count();

        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $rn,
        ]);
        $pagination->setPage($pn);

        $model = $query->offset($pagination->offset)
            ->orderBy('created_at DESC')
            ->limit($pagination->limit)
            ->asArray()->all();

        $arrHotelIds = array();
        foreach ($model as $key => $value) {
            $arrHotelIds[] = $value['hotelid'];
        }

        $arrHotelIds = array_unique($arrHotelIds);

        $hotel = Hotel::find()->select(['hotelname', 'address', 'id'])->where(['in', 'id', $arrHotelIds])->asArray()->all();
        $user = Talentinfo::findIdentity($uid);

        foreach ($model as $key => $value) {
            foreach ($hotel as $item) {
                if ($item['id'] == $value['hotelid']) {
                    $model[$key]['hotelname'] = $item['hotelname'];
                    $model[$key]['address'] = $item['address'];
                }
            }
            if (!empty($user)) {
                $model[$key]['user_name'] = $user->user_name;
                $model[$key]['mobile'] = $user->mobile;
            }
            $model[$key]['total_fee'] = $model[$key]['price'];
            $model[$key]['isfree'] = $model[$key]['ischkinbeforedate'];
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
}