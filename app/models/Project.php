<?php

namespace app\models;


use app\models\Projectapply;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $ptype
 * @property int $status
 * @property string $title
 * @property string $content
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pn', 'rn', 'type'], 'trim'],
            [['pn', 'rn', ], 'required'],

            [['pn', 'rn', 'ptype'], 'integer'],
        ];
    }

    /**
     *
     * @return
     */
    public function get($rn, $pn, $type=null)
    {
        if ($type == null) {
            $query = Project::find()->select(['id','ptype', 'url', 'title', 'jumpurl', 'release_time'])
                ->where(['status' => \Yii::$app->params['talent.status']['published']]);
        } else {
            $query = Project::find()->select(['id', 'url', 'title', 'jumpurl', 'release_time'])
                ->where(['ptype' => $type, 'status' => \Yii::$app->params['talent.status']['published']]);
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
            if (!empty($value['jumpurl'])) {
                $model[$key]['url'] = $value['jumpurl'];
                $model[$key]['isthirdlink'] = 1;
            } else {
                $model[$key]['url'] = $value['url'] . $value['id'];
            }
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
}