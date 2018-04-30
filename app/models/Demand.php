<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $dtype
 * @property int $status
 * @property string $title
 * @property string $content
 * @property string $url
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Demand extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'demand';
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
     *
     * @return
     */
    public function get($rn, $pn, $type)
    {
        $query = Demand::find()->select(['id','status','url', 'title','release_time'])
            ->where(['dtype' => $type, 'status' => \Yii::$app->params['talent.status']['published']]);

        $count = $query->count();

        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $rn,
        ]);
        $pagination->setPage($pn);

        $model = $query->offset($pagination->offset)
            ->orderBy('release_time DESC')
            ->limit($pagination->limit)
            ->asArray()->all();

        foreach ($model as $key => $value) {
            $model[$key]['url'] = $value['url'] . $value['id'];
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
}