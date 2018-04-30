<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  消息
 */

class Adminmessage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%adminmessage}}';
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
            [['title', 'content', 'status'], 'trim'],
            [['title', 'content', 'status'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '消息标题',
            'content' => '消息内容',
            'status' => '消息状态',
        ];
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function search($id)
    {
        $query = Version::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}