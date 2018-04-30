<?php

namespace f\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $showorder
 * @property string $title
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  帮助信息
 */

class Help extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%help}}';
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
            [['id'], 'trim'],
            [['id'], 'required'],
        ];
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = Help::find()->orderBy("showorder ASC");
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}