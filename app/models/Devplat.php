<?php

namespace app\models;

use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $status
 * @property int $category
 * @property string $categoryname
 * @property string $platname
 * @property string $field
 * @property string $plevel
 * @property string $content
 * @property int $plattype
 * @property string $create_year
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Devplat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'devplat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pn', 'rn', 'type'], 'trim'],
            [['pn', 'rn'], 'required'],

            [['pn', 'rn', 'type'], 'integer'],
        ];
    }
    /**
     *
     * @return
     */
    public function get($rn, $pn, $type=null)
    {
        if ($type == 1) {
            $query = Devplat::find(['id', 'platname', 'field', 'plattype', 'url', 'release_time'])
                ->where(['category' => $type, 'status' => \Yii::$app->params['talent.status']['published']]);
        } else if ($type == 2 || $type == 3) {
            $query = Devplat::find(['id', 'platname', 'plevel', 'create_year', 'url', 'release_time'])
                ->where(['category' => $type, 'status' => \Yii::$app->params['talent.status']['published']]);
        } else {
            return [];
        }
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