<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $user_id
 * @property string $title
 * @property string $url
 * @property string $brief
 * @property string $content
 * @property int $treattype
 * @property int $looktype
 * @property int $treatlevel
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Welfare extends ActiveRecord
{
    public $treatlevellist = array();
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%treatment}}';
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
            [['title', 'brief', 'content', 'treattype', 'url', 'looktype', 'status', 'department'], 'trim'],
            [['title', 'content', 'treattype', 'looktype', 'treatlevel', 'department'], 'required'],

            [['treattype', 'looktype', 'treatlevel'], 'integer'],
            [['title','content', 'url' ], 'string'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $arrData = \Yii::$app->getRequest()->post();
        if (isset($arrData['Welfare']['treatlevellist'])) {
            $this->treatlevellist = $arrData['Welfare']['treatlevellist'];

            $this->treatlevel = implode(',', array_values($this->treatlevellist));
        }
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (empty($this->status)) {
                    $this->status = 1;
                }
                //$this->url = \Yii::$app->params['h5urlprefix'] . 'welfare?id=';
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '待遇申请标题',
            'brief' => '待遇简介',
            'content' => '待遇内容',
            'treattype' => '享受类型',
            'looktype' => '查看类型',
            'treatlevel' => '待遇级别',
            'status' => '状态',
            'treatlevellist' => '适用人才级别',
            'department' => '审核部门',
        ];
    }
    /**
     * @inheritdoc
     */
    public function afterFind() {
        parent::afterFind();
        $this->treatlevellist = explode(',', $this->treatlevel);
    }
}