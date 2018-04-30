<?php

namespace app\models;

use Yii;
use yii\base\Model;
/**
 * 伯乐人才奖申请
 */
class BoleRewardApply extends Model
{
    /**
     * @inheritdoc
     */
    public static function savefiles($uid, $applyfiles) {

        $data = [];
        foreach ($applyfiles as $k => $v) {
            $data[] = [
                'user_id' => $uid,
                'applyfile' => strval($v),
                'status' => 1,
                'created_at' => time(),
                'updated_at' => time(),
            ];
        }
        Yii::$app->db->createCommand()->batchInsert('bolerewardapply', ['user_id', 'applyfile', 'status', 'created_at', 'updated_at'], $data)->execute();
    }
}