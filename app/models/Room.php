<?php

namespace app\models;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotelid',], 'trim'],

            [['hotelid'], 'number'],
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
        ];
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function get($arrInput)
    {
        $room = Room::find()->Where(['hotelid' => $arrInput['hotelid'],])
            ->orderBy(['id' => SORT_DESC,])->asArray()->all();

        foreach ($room as $key => $value) {
            $room[$key]['roomtype'] = Yii::$app->params['talent.hotel.roomtype'][$value['roomtype']];
        }

        return $room;
    }
}