<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $treatapplyid
 * @property int $user_id
 * @property string $filesign
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Welfareapplyfiles extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%treatapplyfiles}}';
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
        $model = Welfareapplyfiles::find()->where(['treatapplyid' => $id,])->asArray()->all();
        foreach ($model as $k => $v) {
            $model[$k]['imgurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $v['filesign'];
        }
        return $model;
    }
}