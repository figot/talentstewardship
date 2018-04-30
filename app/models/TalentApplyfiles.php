<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $talentapplyid
 * @property string $filesign
 * @property int $created_at
 * @property int $updated_at
 *
 */

class TalentApplyfiles extends ActiveRecord
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
    public function saveImgs($imgurls, $id) {
        $data = [];
        foreach ($imgurls as $k => $v) {
            foreach ($v['filesigns'] as $kv => $item) {
                $data[] = [
                    'talentapplyid' => $id,
                    'templateid' => $v['templateid'],
                    'filesign' => $item,
                ];
            }
        }
        \Yii::$app->db->createCommand()->batchInsert('talentapplyfiles', ['talentapplyid', 'templateid', 'filesign'], $data)->execute();
    }
}