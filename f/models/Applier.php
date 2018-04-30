<?php

namespace f\models;

use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property int $status
 * @property int $atype
 * @property string $tlevel
 * @property string $title
 * @property string $content
 * @property string $job
 * @property int $company
 * @property string $suit_per
 * @property string $suit_area
 * @property string $portrait
 * @property integer $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Applier extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applier';
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