<?php

namespace app\models;

use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string $url
 * @property int $release_time
 * @property int $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pn', 'rn', 'type'], 'trim'],
            [['pn', 'rn', ], 'required'],

            [['pn', 'rn', 'type'], 'integer'],
        ];
    }
    /**
     *
     * @return
     */
    public function get($rn, $pn, $uid, $type=null)
    {
        $query = Message::find()
            ->select(['id', 'url', 'title', 'content', 'release_time'])
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

//        foreach ($model as $key => $value) {
//            $model[$key]['url'] = $value['url'] . $value['id'];
//        }

        $arrRes = ['list' => $model, 'total' => $count, 'unreads' => $count];

        return $arrRes;
    }
}