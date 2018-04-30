<?php

namespace b\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 *
 * @property integer $id
 * @property int $category
 * @property string $platname
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
class Devplat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'devplat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'platname', 'field', 'plevel', 'plattype', 'create_year', 'content'], 'trim'],
            [['category'], 'number'],
            [['platname', 'content'], 'required'],

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
            'category' =>'平台类别',
            'platname' => '名称',
            'field' => '领域',
            'plevel' => '平台级别',
            'url' => '落地页链接',
            'content' => '内容',
            'plattype' => '平台类型',
            'create_year' =>  '建设年份',
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
                $this->url = Yii::$app->params['h5urlprefix'] . 'devplat?id=';
            }
            return true;
        } else {
            return false;
        }
    }
}