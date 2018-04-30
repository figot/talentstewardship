<?php

namespace app\models;

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

class TreatApplyFiles extends ActiveRecord
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
    public function saveImgs($id, $uid, $imgurls) {
        $data = [];
        foreach ($imgurls as $k => $v) {
            if (!empty($v['filesigns'][0])) {
                $data[] = [
                    'treatapplyid' => $id,
                    'user_id' => $uid,
                    'filesign' => $v['filesigns'][0],
                    'templateid' => $v['templateid'],
                ];
            }
        }
        \Yii::$app->db->createCommand()->batchInsert('treatapplyfiles', ['treatapplyid', 'user_id', 'filesign', 'templateid'], $data)->execute();
    }
}