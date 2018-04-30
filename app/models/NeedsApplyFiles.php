<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $needsapplyid
 * @property int $user_id
 * @property string $filesign
 * @property int $created_at
 * @property int $updated_at
 *
 */

class NeedsApplyFiles extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%needsapplyfiles}}';
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
    public function saveImgs($imgurls, $uid, $id) {
        $data = array();
        foreach ($imgurls as $k => $v) {
            if (!empty($v)) {
                $data[] = array(
                    'needsapplyid' => $id,
                    'user_id' => $uid,
                    'filesign' => $v,
                );
            }
        }
        if (!empty($data)) {
            \Yii::$app->db->createCommand()->batchInsert('needsapplyfiles', ['needsapplyid', 'user_id', 'filesign'], $data)->execute();
        }
    }

    /**
     * @inheritdoc
     */
    public static function findImgs($id) {
        $model = NeedsApplyFiles::find()->where(['needsapplyid' => $id,])->asArray()->all();
        foreach ($model as $k => $v) {
            $model[$k]['imgurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $v['filesign'];
        }
        return $model;
    }
}