<?php

namespace b\models;

use common\models\AdminModel;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property int $hotelid
 * @property int $isroot
 * @property integer $created_at
 * @property integer $updated_at
 */
class Hotelmanage extends \yii\db\ActiveRecord
{
    public $hotel;
    public $user;
    public $hotelarealist;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotelmanage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'hotelid', 'isroot', 'hotelarea', 'hotelarealist'], 'trim'],
            [['user_id'], 'required'],
        ];
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
    public function getAdmin()
    {
        return $this->hasOne(AdminModel::className(), ['id' => 'user_id']);
    }
    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['id' => 'hotelid']);
    }
    /**
     * @inheritdoc
     */
    public function saveData($id) {
        $hotelmanage = Hotelmanage::find()->where(['user_id' => $id])->one();
        if ($hotelmanage !== null) {
            $eid = $hotelmanage->id;
            $hotelmanage->attributes = $this->attributes;
            $hotelmanage->id = $eid;
            if (!$hotelmanage->save(false)) {
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
     *
     * @return
     */
    public function search($params)
    {
        $query = Hotelmanage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id' => $this->id,
        ]);

        return $dataProvider;
    }
    public static function getHotelname($id, $hotelinfo) {
        $hotelname = '';
        if (isset($hotelinfo[$id])) {
            $hotelname = $hotelinfo[$id];
        }
        return $hotelname;
    }


    public static function getHotelinfo() {
        $arrRes = array();
        $hotel = Hotel::find()->select(['id', 'hotelname'])->asArray()->all();
        foreach ($hotel as $k => $v) {
            $arrRes[$v['id']] = $v['hotelname'];
        }
        return $arrRes;
    }
    public static function getUsername($id, $userinfo) {
        $username = '';
        if (isset($userinfo[$id])) {
            $username = $userinfo[$id];
        }
        return $username;
    }
    public static function getUserinfo() {
        $arrRes = array();
        $user = AdminModel::find()->select(['id', 'username'])->asArray()->all();
        foreach ($user as $k => $v) {
            $arrRes[$v['id']] = $v['username'];
        }
        return $arrRes;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户',
            'hotelid' => '酒店',
            'isroot' => '酒店用户/市委管理员',
            'hotelarealist' => '酒店区域列表',
        ];
    }
    /**
     * @inheritdoc
     */
    public function afterFind() {
        parent::afterFind();
        $this->hotelarealist = explode(',', $this->hotelarea);
    }
}