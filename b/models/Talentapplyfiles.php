<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $talentapplyid
 * @property int $templateid
 * @property string $filesign
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Talentapplyfiles extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentapplyfiles}}';
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
    public static function findImgs($id) {
        $model = Talentapplyfiles::find()->where(['talentapplyid' => $id,])->all();
        return $model;
    }
}