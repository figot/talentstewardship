<?php

namespace b\models;

use Yii;

use yii\behaviors\TimestampBehavior;

/**
 *
 * @property integer $id
 * @property int $status
 * @property string $title
 * @property string $content
 * @property int $release_time
 * @property string $thumbnail
 * @property string $url
 * @property string $jumpurl
 * @property integer $created_at
 * @property integer $updated_at
 */
class Ad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'thumbnail', 'url', 'jumpurl', 'status'], 'trim'],

            [['title','content', 'thumbnail', 'url', 'jumpurl' ], 'string'],
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
    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'content' => '内容',
            'thumbnail' => '轮播图',
            'status' => '状态',
            'jumpurl' => '外部链接'
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
                if (empty($this->jumpurl)) {
                    $this->url = Yii::$app->params['h5urlprefix'] . 'ad?id=';
                }
                $this->release_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
}