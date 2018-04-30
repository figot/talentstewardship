<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $talentcategoryid
 * @property string $isrequired
 * @property string $filetemplateurl
 * @property string $templatename
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  待遇申请模板文件
 */

class Treattemplate extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%treattemplate}}';
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
            [['id', 'treatid', 'isrequired', 'filetemplateurl', 'templatename'], 'trim'],

            [['isrequired'], 'number'],
        ];
    }
}