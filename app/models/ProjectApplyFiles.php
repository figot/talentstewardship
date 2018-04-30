<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $projectapplyid
 * @property int $user_id
 * @property string $filesign
 * @property int $created_at
 * @property int $updated_at
 *
 */

class ProjectApplyFiles extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%projectapplyfiles}}';
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
        if ($id > 0 && $uid > 0) {
            ProjectApplyFiles::deleteAll([
                'and',
                'projectapplyid = :projectapplyid',
                'user_id = :user_id',
                ],
                [
                    ':projectapplyid' => $id,
                    ':user_id' => $uid,
                ]
            );
        }
        foreach ($imgurls as $k => $v) {
            if (!empty($v) && !empty($v['filesigns'][0])) {
                $data[] = [
                    'projectapplyid' => $id,
                    'user_id' => $uid,
                    'templateid' => $v['templateid'],
                    'filesign' => $v['filesigns'][0],
                ];
            }
        }
        if (!empty($data)) {
            \Yii::$app->db->createCommand()->batchInsert('projectapplyfiles', ['projectapplyid', 'user_id', 'templateid', 'filesign'], $data)->execute();
        }
    }
}