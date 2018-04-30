<?php
namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property int $talentcategoryid
 * @property int $templateid
 * @property string $remark
 * @property int $applystatus
 * @property string $talentlevel
 * @property integer $status
 *
 */

class Talentapply extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentapply}}';
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
            [['id', 'user_id', 'talentcategoryid', 'remark'], 'trim'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function saveData($uid) {
        $this->user_id = $uid;
        $this->applystatus = \Yii::$app->params['talent.authstatus']['authing'];
        $apply = Talentapply::findIdentity($this->talentcategoryid, $this->user_id);
        if ($apply !== null) {
            $apply->attributes = $this->attributes;
            if (!$apply->save(false)) {
                throw new \Exception();
            }
            $applyid = $apply->attributes['id'];
        } else {
            if (!$this->save(false)) {
                throw new \Exception();
            }
            $applyid = $this->attributes['id'];
        }
        return $applyid;
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id, $uid)
    {
        return static::findOne(['talentcategoryid' => $id, 'user_id' => $uid]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'talentlevel' => '人才分类的级别名称',
        ];
    }
}