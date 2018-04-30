<?php

namespace app\models;

use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property string $department
 * @property int $acttype
 * @property string $title
 * @property string $content
 * @property int $activity_time
 * @property string $activity_pos
 * @property int user_cnt
 * @property string $thumbnail
 * @property int $status
 * @property int $read_count
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pn', 'rn', 'type'], 'trim'],
            [['pn', 'rn', ], 'required'],

            [['pn', 'rn', 'ctype'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'content' => '内容',
        ];
    }
    /**
     *
     * @return
     */
    public function get($rn, $pn, $type)
    {
        $query = Activity::find()
            ->select(['id', 'department', 'title', 'url', 'activity_time', 'activity_pos', 'user_cnt', 'thumbnail', 'read_count', 'release_time'])
            ->where(['acttype' => $type, 'status' => \Yii::$app->params['talent.status']['published']]);

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
            if (!empty($value['thumbnail'])) {
                $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
            }
            $model[$key]['url'] = $value['url'] . $value['id'];
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
}