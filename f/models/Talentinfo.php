<?php

namespace f\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $user_id
 * @property string $mobile
 * @property string $user_name
 * @property string $gender
 * @property string $id_number
 * @property string $pol_visage
 * @property string $address
 * @property string $email
 * @property string $qq
 * @property string $wechat
 * @property string $brief
 * @property string $portrait
 * @property integer $status
 * @property string $good_fields
 * @property string $category
 * @property int $isshow
 *
 */

class Talentinfo extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentinfo}}';
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

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }

}