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
            [['id', 'name'], 'trim'],
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
        $departconf = array();
        $firstlevel = array();
        $depart = Depart::find()->select(['department', 'subdepart'])->orderBy("id DESC")->asArray()->all();
        foreach ($depart as $k => $v) {
            $firstlevel[$v['department']][] = $v['subdepart'];
        }
        foreach ($firstlevel as $key => $value) {
            $departconf[] =  array(
                'department' => $key,
                'subdepart' => array_unique($value),
            );
        }
        return $departconf;
    }
}