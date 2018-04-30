<?php

namespace f\models;

use f\models\Talentinfo;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use app\models\User;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $county
 * @property int $onlinecnt
 * @property int $incnt
 * @property int $outcnt
 * @property string $url
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  人才活跃指数
 */

class Activeindex extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentactiveindex}}';
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

        ];
    }
    /**
     * @inheritdoc
     */
    public function getActiveindex() {
        $sum = 0;
        $incnt = 0;
        $ressum = 0;
        $data = Activeindex::find()->asArray()->all();
        return $data;
        $tcnt = Talentinfo::find()->count();
        foreach ($data as $key => $item) {
            $sum += $item['onlinecnt'];
            $incnt += $item['incnt'];
        }
        $arrRes = array(
            'data' => $data,
            'statictics' => array(
                'incnt' => $incnt,
                'totalactivecnt' => $sum,
                'talentcnt' => $tcnt,
            ),
        );

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'onlinecnt' => '在线活跃人数',
            'incnt' => '人才流入数',
            'outcnt' => '人才流出数',
        ];
    }
}