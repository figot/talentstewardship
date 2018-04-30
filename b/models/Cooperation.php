<?php

namespace b\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property int $ctype
 * @property int $status
 * @property string $title
 * @property string $content
 * @property string $url
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Cooperation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cooperation';
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
            [['title', 'content', 'ctype', 'status'], 'trim'],

            [['ctype', 'title', 'content'], 'required'],
            ['ctype', 'in', 'range' => [1, 2, 3, 4]],

            [['ctype'], 'number'],
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
                $this->url = Yii::$app->params['h5urlprefix'] . 'coop?id=';
                $this->release_time = time();
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
            'ctype' => '项目类型',
            'status' => '状态',
            'title' => '标题',
            'url' => '落地页地址',
            'content' => '内容',
            'release_time' => '发布时间',
        ];
    }
}