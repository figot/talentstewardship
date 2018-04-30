<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property string $applystatus
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Needs extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%needs}}';
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
    public function rules()
    {
        return [
            [['department', 'subdepart', 'title', 'content'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function saveData($uid, $applyfiles, $id=null) {
        $this->user_id = $uid;
        $needs = null;
        if (isset($id)) {
            $needs = Needs::findOne(['id' => $id]);
        }
        if ($needs !== null) {
            $needs->applystatus = 1;
            $needs->attributes = $this->attributes;
            if (!$needs->save(false)) {
                throw new \Exception();
            }
        } else {
            $this->applystatus = 1;
            if (!$this->save(false)) {
                throw new \Exception();
            }
            $id = $this->attributes['id'];
        }
        if (!empty($id)) {
            return $id;
        }
    }
    /**
     *
     * @return
     */
    public function get($id)
    {
        $needs = Needs::find()->where(['user_id' => $id])->asArray()->all();
        $cnt = Needs::find()->where(['user_id' => $id])->count();

        $applyids = array();
        foreach ($needs as $v) {
            $applyids[] = $v['id'];
        }
        $applyfiles = NeedsApplyFiles::find()->where(['in', 'needsapplyid', $applyids])
            ->asArray()->all();

        foreach ($needs as $key => $value) {
            $needs[$key]['status_name'] = \Yii::$app->params['talent.applystatusname2'][$value['applystatus']];
            foreach ($applyfiles as $filesign) {
                if ($filesign['needsapplyid'] == $value['id']) {
                    $needs[$key]['fileurls'][] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $filesign['filesign'];
                }
            }
        }

        $arrRes = ['list' => $needs, 'total' => $cnt];
        return $arrRes;
    }
}