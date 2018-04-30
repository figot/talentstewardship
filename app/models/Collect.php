<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property int $cid
 * @property int $ctype
 * @property string $url
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 收藏信息
 */

class Collect extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%collect}}';
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
            [['user_id', 'cid', 'ctype'], 'trim'],
            [['cid', 'ctype'], 'required'],

            [['cid', 'ctype'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function saveData() {
        $collect = Collect::findOne(['cid' => $this->cid, 'user_id' => $this->user_id]);
        if ($collect !== null) {
            $collect->collect_status = 1;
            if (!$collect->save(false)) {
                throw new \Exception();
            }
        } else {
            $this->collect_status = 1;
            if (!$this->save(false)) {
                throw new \Exception();
            }
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function Cancell() {
        $collect = Collect::findOne(['cid' => $this->cid, 'user_id' => $this->user_id]);
        if ($collect !== null) {
            $collect->collect_status = 0;
            if (!$collect->save(false)) {
                throw new \Exception();
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     *
     * @return
     */
    public function get($uid, $rn, $pn)
    {
        $query = Collect::find()->select(['cid', 'ctype', 'id'])->where(['user_id' => $uid, 'collect_status' => 1]);

        $count = $query->count();

        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $rn,
        ]);
        $pagination->setPage($pn);

        $collect = $query->offset($pagination->offset)
            ->orderBy('id DESC')
            ->limit($pagination->limit)
            ->asArray()->all();

        $arrNewsIds = array();
        $arrPolicyIds = array();
        foreach ($collect as $key => $value) {
            if ($value['ctype'] == 2) {
                $arrNewsIds[] = $value['cid'];
            } else if ($value['ctype'] == 1) {
                $arrPolicyIds[] = $value['cid'];
            }
        }

        if (!empty($arrPolicyIds)) {
            $policy = Policy::find()->select(['id', 'url', 'title', 'release_time','thumbnail','can_share', 'read_count'])
                ->andWhere(['status' => \Yii::$app->params['talent.status']['published']])
                ->andWhere(['in', 'id', $arrPolicyIds])
                ->asArray()->all();
        }

        if (!empty($arrNewsIds)) {
            $news = News::find()->select(['id', 'url', 'title','release_time','thumbnail','can_share', 'read_count'])
                ->andWhere(['status' => \Yii::$app->params['talent.status']['published']])
                ->andWhere(['in', 'id', $arrNewsIds])
                ->asArray()->all();
        }

        $temp = array();
        foreach ($collect as $key => $value) {
            if ($value['ctype'] == 2) {
                foreach ($news as $nv) {
                    if ($nv['id'] == $value['cid']) {
                        $temp[$key] = array_merge($value, $nv);
                        $temp[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $nv['thumbnail'];
                        $temp[$key]['url'] = $nv['url'] . $nv['id'];
                        $temp[$key]['type'] = 2;
                    }
                }
            } else if ($value['ctype'] == 1) {
                foreach ($policy as $pv) {
                    if ($pv['id'] == $value['cid']) {
                        $temp[$key] = array_merge($value, $pv);
                        $temp[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $pv['thumbnail'];
                        $temp[$key]['url'] = $pv['url'] . $pv['id'];
                        $temp[$key]['type'] = 1;
                    }
                }
            }
        }
        $res =array();
        foreach ($temp as $tp => $kp) {
            $res[] = $kp;
        }

        $arrRes = ['list' => $res, 'total' => $count];

        return $arrRes;
    }

}