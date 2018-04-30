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
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 */
class Devtrends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'devtrends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'title', 'content'], 'trim'],
            [['title', 'content'], 'required'],

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
            'url' => '落地页地址',
            'status' => '状态',
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
                    $this->status = 2;
                }
                $this->release_time = time();
                $this->url = Yii::$app->params['h5urlprefix'] . 'devtrends?id=';
            }
            return true;
        } else {
            return false;
        }
    }
}