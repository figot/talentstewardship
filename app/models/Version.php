<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property integer $url
 * @property string $version
 * @property string $ostype
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief version信息
 */

class Version extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%version}}';
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