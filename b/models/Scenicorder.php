<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $vipchannelid
 * @property string $chkindt
 * @property string $chkoutdt
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief vip通道订单
 */

class Scenicorder extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%scenicorder}}';
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
            [['status'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '景区名称',
            'status' => '状态',
        ];
    }
}