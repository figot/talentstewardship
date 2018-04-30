<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property integer $name
 * @property string $area
 * @property string $address
 * @property string $thumbnail
 * @property double $longitude
 * @property double $latitude
 * @property string $url
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief vip通道信息
 */

class Vipchannel extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vipchannel}}';
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
    public function attributeLabels()
    {
        return [
            'name' => 'vip通道名称',
            'area' => 'vip通道地区',
            'address' => '详细地址',
            'thumbnail' => '缩略图链接',
        ];
    }

    /**
     *
     * @return
     */
    public function get($rn, $pn, $arrReq, $type=null)
    {
        $query = Vipchannel::find(['name', 'thumbnail', 'address'])
            ->where(['status' => \Yii::$app->params['talent.status']['published']]);

        $count = $query->count();

        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $rn,
        ]);
        $pagination->setPage($pn);

        $model = $query->offset($pagination->offset)
            ->orderBy('id DESC')
            ->limit($pagination->limit)
            ->asArray()->all();

        foreach ($model as $key => $value) {
            $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
            //$model[$key]['distance'] = rand(10000,99999)/1137;
            if (empty($arrReq['latitude'])) {
                $arrReq['latitude'] = 0;
            }
            if (empty($arrReq['latitude'])) {
                $arrReq['longitude'] = 0;
            }
            //$model[$key]['distance'] = intval(sqrt(pow(intval($value['latitude']) - intval($arrReq['latitude']), 2) + pow(intval($value['longitude']) - intval($arrReq['longitude']), 2)));
            $model[$key]['distance'] = self::longlatToDistance($value['longitude'], $value['latitude'], $arrReq['longitude'], $arrReq['latitude']);
            $model[$key]['url'] = $value['url'] . $value['id'];
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
    /**
     *
     * @return
     */
    public static function longlatToDistance($longitude1, $latitude1, $longitude2, $latitude2) {
        $lat1 = self::rad($latitude1); // 纬度
        $lat2 = self::rad($latitude2);

        $a = $lat1 - $lat2;//两点纬度之差
        $b = self::rad($longitude1) - self::rad($longitude2); //经度之差

        $s = 2 * asin(sqrt(pow(sin($a/2), 2) + cos($lat1) * cos($lat2) * pow(sin($b/2), 2)));//计算两点距离的公式
        $s = intval($s * 6378.137);//弧长乘地球半径（半径为米）
        return $s;
    }
    /**
     *
     * @return
     */
    private static function rad($d) {
        return $d * pi() / 180.00; //角度转换成弧度
    }
}