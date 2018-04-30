<?php
namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 *
 */

class Area extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area}}';
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
            [['id', 'name'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '区域分类名称',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function getAreas() {
        $areaconf = array();
        $area = Area::find()->select(['name'])->asArray()->all();
        foreach ($area as $key => $value) {
            $areaconf = array_merge($areaconf, array($value['name'] => $value['name']));
        }
        return $areaconf;
    }
}