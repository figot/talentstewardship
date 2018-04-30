<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property string $name
 * @property string $category
 * @property string $iconurl
 * @property string $url
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 第三方服务信息
 */

class Lifeservice extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lifeservice}}';
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
            [['name', 'category', 'iconurl', 'url'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '服务名称',
            'category' => '类别',
            'iconurl' => '图标地址',
            'url' => '跳转地址',
        ];
    }

    /**
     *
     * @return
     */
    public function get()
    {
        $lifeservice = Lifeservice::find()->Where(['status' => \Yii::$app->params['talent.status']['published'],])
            ->orderBy(['id' => SORT_ASC])->all();

        $category = [];
        $res = [];
        foreach ($lifeservice as $key => $value) {
            $value['iconurl'] = \Yii::$app->request->getHostInfo() . $value['iconurl'];
            $category[$value['category']][] = $value;
        }

        foreach ($category as $k => $v) {
            $res[] = array(
                'category' => $k,
                'servicelist' => $v,
            );
        }

        return $res;
    }
}