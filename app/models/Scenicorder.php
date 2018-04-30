<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property integer $scenicid
 * @property int $user_id
 * @property int $chkindt
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 景区订单信息
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
            [['user_id', 'scenicid'], 'trim'],
            [['user_id', 'scenicid'], 'required'],

            [['user_id', 'scenicid'], 'number'],
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