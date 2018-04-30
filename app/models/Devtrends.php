<?php

namespace app\models;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $status
 * @property string $title
 * @property string $content
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Devtrends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'devtrends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pn', 'rn'], 'trim'],
            [['pn', 'rn'], 'required'],

            [['pn', 'rn'], 'integer'],
        ];
    }

    /**
     *
     * @return
     */
    public function get($rn, $pn, $type=null)
    {
        $query = Devtrends::find(['id', 'url', 'title', 'release_time'])
            ->where(['status' => \Yii::$app->params['talent.status']['published']]);

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