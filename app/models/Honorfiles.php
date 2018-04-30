<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $honorid
 * @property int $user_id
 * @property string $filesign
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Honorfiles extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%honorfiles}}';
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
        \Yii::info(json_encode($imgurls, true));
        $data = [];
        foreach ($imgurls as $k => $v) {
            if (!empty($v)) {
                $data[] = [
                    'honorid' => $id,
                    'user_id' => $uid,
                    'filesign' => $v,
                ];
            }
        }
        if (!empty($data)) {
            \Yii::$app->db->createCommand()->batchInsert('honorfiles', ['honorid', 'user_id', 'filesign'], $data)->execute();
        }
    }
}