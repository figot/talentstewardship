<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property integer $vipchannelid
 * @property int $user_id
 * @property int $chkindt
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief vip通道订单信息
 */

class Vipchannelorder extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vipchannelorder}}';
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
            [['user_id', 'vipchannelid'], 'trim'],
            [['user_id', 'vipchannelid'], 'required'],

            [['user_id', 'vipchannelid'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function saveData() {
        $this->chkindt = time();
        if (!$this->save(false)) {
            throw new \Exception();
        }
        return true;
    }

}