<?php

namespace app\models;
use yii\data\Pagination;

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
class Policy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'policy';
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
    public function get($rn, $pn, $uid, $type=null)
    {
        if ($type == null) {
            $query = Policy::find()->select(['id','department','url', 'policytype','status','title','url', 'release_time','thumbnail','can_share', 'read_count'])
                ->where(['status' => \Yii::$app->params['talent.status']['published']]);
        } else {
            $query = Policy::find()->select(['id','department','url', 'policytype','status','title','url', 'release_time','thumbnail','can_share', 'read_count'])
                ->where(['status' => \Yii::$app->params['talent.status']['published'], 'policytype' => $type]);
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
            ->andWhere(['user_id' => $uid, 'ctype' => 1])
            ->andWhere(['in', 'cid', $arrIds])
            ->asArray()->all();

        foreach ($model as $key => $value) {
            $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
            $model[$key]['url'] = $value['url'] . $value['id'];
            foreach ($collect as $item) {
                if ($item['cid'] == $value['id']) {
                    $model[$key]['collect_status'] = $item['collect_status'];
                }
            }
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
}