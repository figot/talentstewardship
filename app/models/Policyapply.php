<?php

namespace app\models;
use yii\data\Pagination;
use yii\behaviors\TimestampBehavior;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property int $policyid
 * @property int $status
 * @property int $applytime
 * @property integer $created_at
 * @property integer $updated_at
 */
class Policyapply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'policyapply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
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
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (empty($this->status)) {
                    $this->status = 1;
                }
                $this->applytime = time();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function saveData($id, $uid) {
        $this->user_id = $uid;
        $this->policyid = $id;
        $apply = Policyapply::findOne(['policyid' => $id, 'user_id' => $uid]);
        if ($apply !== null) {
            $apply->attributes = $this->attributes;
            if (!$apply->save(false)) {
                throw new \Exception();
            }
        } else {
            if (!$this->save(false)) {
                throw new \Exception();
            }
        }
        return true;
    }
}