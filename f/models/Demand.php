<?php

namespace f\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property int $dtype
 * @property int $status
 * @property string $title
 * @property string $content
 * @property string $url
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Demand extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'demand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'trim'],
            [['id', ], 'required'],

            [['id'], 'integer'],
        ];
    }
}