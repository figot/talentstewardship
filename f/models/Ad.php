<?php

namespace f\models;

use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property int $status
 * @property string $title
 * @property string $content
 * @property int $release_time
 * @property string $thumbnail
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 */
class Ad extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'trim'],
            [['id'], 'required'],
        ];
    }
}