<?php

namespace f\models;

use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property int $status
 * @property string $devicename
 * @property string $category
 * @property string $content
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Deviceshare extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deviceshare';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'trim'],
            [['id'], 'required'],

            [['id'], 'integer'],
        ];
    }
}