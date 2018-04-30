<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $hotelid
 * @property string $imageurl
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  酒店照片
 */

class Hotelimages extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotelimages}}';
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
            [['hotelid'], 'trim'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '照片',
            'hotelid' => '酒店',
            'imageurl' => '酒店图片',
            'status' => '状态',
        ];
    }
    /**
     * @inheritdoc
     */
    public function get($arrInput)
    {
        $hotelid = intval($arrInput['hotelid']);
        $model = Hotelimages::find()->select(['imageurl'])->where(['hotelid' => $hotelid])->asArray()->all();
        $arrRes = [];
        foreach ($model as $key => $value) {
            $arrRes[] = \Yii::$app->params['hostname'] . $value['imageurl'];
        }
        return $arrRes;
    }
}