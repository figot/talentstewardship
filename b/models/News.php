<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;

/**
 *
 * @property integer $id
 * @property int $newstype
 * @property string $typename
 * @property int $status
 * @property string $title
 * @property string $content
 * @property int $can_share
 * @property int $release_time
 * @property string $thumbnail
 * @property int $read_count
 * @property integer $created_at
 * @property integer $updated_at
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['newstype', 'title', 'content', 'thumbnail', 'status'], 'trim'],
            [['newstype', 'title', 'content', 'thumbnail'], 'required'],

            [['newstype', 'can_share'], 'integer'],
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
            'thumbnail' => '缩略图',
            'newstype' => '资讯类型',
            'typename' => '资讯类型名称',
            'can_share' => '是否能够分享',
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
                $this->typename = \Yii::$app->params['talent.newsType'][$this->newstype];
                $this->release_time = time();
                $this->url = \Yii::$app->params['h5urlprefix'] . 'news?id=';
            }
            return true;
        } else {
            return false;
        }
    }
}