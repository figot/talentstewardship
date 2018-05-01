<?php
namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property string $department
 * @property string $subdepart
 * @property integer $status
 *
 */

class Depart extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%depart}}';
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
            [['id', 'department', 'subdepart'], 'trim'],
            [['department',], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department' => '一级组织机构',
            'subdepart' => '二级组织机构',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function getDeparts() {
        $areaconf = array();
        $area = Depart::find()->select(['department'])->asArray()->all();
        foreach ($area as $key => $value) {
            $areaconf = array_merge($areaconf, array($value['department'] => $value['department']));
        }
        return $areaconf;
    }
    /**
     * @inheritdoc
     */
    public static function getSecondDeparts() {
        $areaconf = array();
        $area = Depart::find()->select(['subdepart'])->asArray()->all();
        foreach ($area as $key => $value) {
            $areaconf = array_merge($areaconf, array($value['subdepart'] => $value['subdepart']));
        }
        return $areaconf;
    }
    /**
     * @inheritdoc
     */
    public static function getSecondDepartsById() {
        $areaconf = array();
        $area = Depart::find()->select(['id', 'subdepart'])->asArray()->all();
        foreach ($area as $key => $value) {
            $areaconf = array_merge($areaconf, array($value['id'] => $value['subdepart']));
        }
        return $areaconf;
    }
}