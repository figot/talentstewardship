<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property string $educate
 * @property string $talentlevel
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  信息
 */

class Educationlevelconf extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%educationlevelconf}}';
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
}