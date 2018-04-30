<?php

namespace f\models;

use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property int $ctype
 * @property int $status
 * @property string $title
 * @property string $content
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Devplat extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'devplat';
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