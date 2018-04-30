<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property integer $hotelname
 * @property string $area
 * @property string $address
 * @property string suitper
 * @property string $star
 * @property string $thumbnail
 * @property string $image
 * @property double longitude
 * @property double latitude
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 酒店信息
 */

class Hotel extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotel}}';
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
            [['area', 'suitper', 'longitude', 'latitude'], 'trim'],
            [['longitude', 'latitude'], 'double'],
            [['area'], 'string', 'length' => [1, 10]],
            [['suitper'], 'in', 'range' => ['A类', 'B类', 'C类']]
        ];
    }

    /**
     *
     * @return
     */
    public function get($rn, $pn, $arrReq, $type=null)
    {
        $query = Hotel::find()->where(['status' => \Yii::$app->params['talent.status']['published']]);
        if (!empty($this->suitper)) {
            $query->andWhere(['suitper' => $this->suitper,]);
        }
        if (!empty($this->area)) {
            $query->andWhere(['like', 'area', $this->area]);
        }

        $count = $query->count();

        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $rn,
        ]);
        $pagination->setPage($pn);

        $model = $query->offset($pagination->offset)
            ->orderBy(['score' => SORT_DESC,])
            ->limit($pagination->limit)
            ->asArray()->all();

        foreach ($model as $key => $value) {
            $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
            if (empty($arrReq['latitude'])) {
                $arrReq['latitude'] = 0;
            }
            if (empty($arrReq['latitude'])) {
                $arrReq['longitude'] = 0;
            }
            $model[$key]['distance'] = self::longlatToDistance($value['longitude'], $value['latitude'], $arrReq['longitude'], $arrReq['latitude']);
            //$model[$key]['distance'] = intval(sqrt(pow(intval($value['latitude']) - intval($arrReq['latitude']), 2) + pow(intval($value['longitude']) - intval($arrReq['longitude']), 2)));
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
    /**
     *
     * @return
     */
    public function getDetail($arrReq)
    {
        $hotelinfo = Hotel::find()->select(['hotelname', 'address'])->Where(['id' => $arrReq['hotelid'],])->asArray()->one();

        return $hotelinfo;
    }
    /**
     *
     * @return
     */
    public function getByDist($rn, $pn, $type=null)
    {
        $query = Hotel::find()->Where(['suitper' => $this->suitper, 'status' => \Yii::$app->params['talent.status']['published']])
            ->Where(['like', 'area', $this->area]);

        $count = $query->count();

        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $rn,
        ]);
        $pagination->setPage($pn);

        $model = $query->offset($pagination->offset)
            ->orderBy(['score' => SORT_DESC,])
            ->limit($pagination->limit)
            ->asArray()->all();

        foreach ($model as $key => $value) {
            $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
            $model[$key]['distance'] = intval($key) + 0.1;
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

    /**
     *
     * @return 根据距离排序
     */
//    public function getByDist1($arrInput)
//    {
//        $hotelinfo = Hotel::find()->Where(['suitper' => $this->suitper,])
//            ->Where(['like', 'area', $this->area])->orderBy(['score' => SORT_DESC,])->all();
////        $hotelinfo = Hotel::find()->Where(['suitper' => $this->suitper,])
////            ->Where(['like', 'area', $this->area])->orderBy([new Expression(abs($arrInput['longitude'] - 'FIELD([[longitude]])')+abs($arrInput['latitude'] - 'FIELD([[latitude]])')) => SORT_ASC,])->all();
//
//        return $hotelinfo;
//    }
}