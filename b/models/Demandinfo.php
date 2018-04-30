<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property int $dtype
 * @property int $status
 * @property string $title
 * @property string $content
 * @property string $url
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Demandinfo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'demand';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dtype','title', 'content', 'url', 'status'], 'trim'],
            [['dtype', 'title', 'content'], 'required'],

            [['dtype'], 'integer'],
            [['title','content', 'url' ], 'string'],
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
            'dtype' => '类型',
            'title' => '标题',
            'content' => '内容',
            'url' => '链接',
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
                $this->url = \Yii::$app->params['h5urlprefix'] . 'demandinfo?id=';
                $this->release_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
}