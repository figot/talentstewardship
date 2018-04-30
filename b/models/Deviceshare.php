<?php

namespace b\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 *
 * @property integer $id
 * @property string $category
 * @property string $devicename
 * @property string $content
 * @property string $field
 * @property string $plevel
 * @property string $plattype
 * @property string $create_year
 * @property int $release_time
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 */
class Deviceshare extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deviceshare';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['devicename', 'content'], 'trim'],
            [['devicename', 'content'], 'required'],

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
            'status' => '状态',
            'category' =>'类别',
            'devicename' => '名称',
            'url' => '落地页链接',
            'content' => '内容',
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
                $this->url = Yii::$app->params['h5urlprefix'] . 'deviceshare?id=';
            }
            return true;
        } else {
            return false;
        }
    }
}