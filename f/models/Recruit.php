<?php

namespace f\models;

use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property string $department
 * @property int $status
 * @property string $title
 * @property string $content
 * @property string $job
 * @property string $welfare
 * @property int $company
 * @property string $attibute
 * @property string $salary
 * @property integer $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Recruit extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recruit';
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