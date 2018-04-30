<?php

namespace b\models;

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
            [['hotelid', 'imageurl'], 'trim'],

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
            'imageurl' => '上传酒店图片',
            'status' => '状态',
        ];
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function saveImgs($id, $imgurls) {

        $data = [];
        foreach ($imgurls as $k => $v) {
            $data[] = [
                'hotelid' => $id,
                'imageurl' => $v,
            ];
        }
        Yii::$app->db->createCommand()->batchInsert('hotelimages', ['hotelid', 'imageurl'], $data)->execute();
    }
    /**
     * @inheritdoc
     */
    public function search($id)
    {
        $query = Hotelimages::find()->where(['hotelid' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}