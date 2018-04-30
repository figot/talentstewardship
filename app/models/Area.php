<?php
namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property string $talentlevel
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
            'name' => '市县区域名称',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function getAreas() {
        $areaconf = array();
        $area = Area::find()->select(['name'])->asArray()->all();
        foreach ($area as $key => $value) {
            $areaconf[] =  $value['name'];
        }
        return $areaconf;
    }
}