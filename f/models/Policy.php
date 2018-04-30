<?php

namespace f\models;

use yii\db\ActiveRecord;

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
class Policy extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'policy';
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