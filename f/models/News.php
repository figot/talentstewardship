<?php

namespace f\models;

/**
 *
 * @property integer $id
 * @property string $department
 * @property int $policytype
 * @property int $pol_status
 * @property string $title
 * @property string $content
 * @property string $suit_per
 * @property string $suit_area
 * @property int $release_time
 * @property string $thumbnail
 * @property int $read_count
 * @property integer $created_at
 * @property integer $updated_at
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
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