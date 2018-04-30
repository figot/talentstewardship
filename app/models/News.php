<?php

namespace app\models;

use yii\data\Pagination;
use app\models\Collect;

/**
 *
 * @property integer $id
 * @property string $department
 * @property int $policytype
 * @property int $pol_status
 * @property string $title
 * @property string $content
 * @property string $suit_per
 * @property string $suit_area
 * @property int $release_time
 * @property string $thumbnail
 * @property int $read_count
 * @property integer $created_at
 * @property integer $updated_at
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
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
        if ($type == null) {
            $query = News::find()
                ->select(['id', 'url', 'newstype','status','title','release_time','thumbnail','can_share', 'read_count'])
                ->where(['status' => \Yii::$app->params['talent.status']['published']]);
        } else {
            $query = News::find()
                ->select(['id', 'newstype','url', 'status','title','release_time','thumbnail', 'can_share', 'read_count'])
                ->where(['newstype' => $type, 'status' => \Yii::$app->params['talent.status']['published']]);
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

        $arrIds = array();
        foreach ($model as $value) {
            $arrIds[] = $value['id'];
        }

        $collect = $query = Collect::find()->select(['cid', 'collect_status'])
            ->andWhere(['user_id' => $uid, 'ctype' => 2])
            ->andWhere(['in', 'cid', $arrIds])
            ->asArray()->all();

        foreach ($model as $key => $value) {
            $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
            $model[$key]['url'] = $value['url'] . $value['id'];
            foreach ($collect as $v) {
                if ($v['cid'] == $value['id']) {
                    $model[$key]['collect_status'] = $v['collect_status'];
                }
            }
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
}