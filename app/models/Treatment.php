<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\models\Treatapply;
use app\models\TreatApplyFiles;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $treattype
 * @property string $treatlevel
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Treatment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%treatment}}';
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
            [['pn', 'rn'], 'trim'],
            [['pn', 'rn'], 'required'],
            [['pn', 'rn'], 'number'],
        ];
    }

    /**
     *
     * @return
     */
    public function getData($rn, $pn, $uid)
    {
        $treat = Treatment::find()->select(['id', 'treattype', 'looktype', 'title', 'url'])->where(['status' => \Yii::$app->params['talent.status']['published']])->orderBy('id DESC')->limit($rn)->offset($rn*$pn)->asArray()->all();
        $cnt = Treatment::find()->select(['id', 'treattype', 'looktype', 'title'])->where(['status' => \Yii::$app->params['talent.status']['published']])->count();

        $apply = Treatapply::find()->select(['id', 'treatid', 'applystatus'])->where(['user_id' => $uid])->asArray()->all();

        foreach ($treat as $key => $value) {
            if ($value['treattype'] == \Yii::$app->params['talent.treat.applytype']) {
                if (isset($apply['treatid']) && $value['id'] == $apply['treatid']) {
                    $treat[$key]['applystatus'] = $apply['applystatus'];
                } else {
                    $treat[$key]['applystatus'] = \Yii::$app->params['talent.applystatus']['noapply'];
                }
            }
        }

        $arrRes = ['list' => $treat, 'total' => $cnt];
        return $arrRes;
    }
    /**
     *
     * @return
     */
    public function get($rn, $pn, $uid)
    {
        $query = Treatment::find(['id', 'treattype', 'looktype', 'title', 'brief'])
            ->where(['status' => \Yii::$app->params['talent.status']['published']]);

        $count = $query->count();

        $talentinfo = Talentinfo::find()->select(['user_name', 'id_number'])->where(['user_id' => $uid])->one();

        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $rn,
        ]);
        $pagination->setPage($pn);

        $model = $query->offset($pagination->offset)
            ->orderBy('id DESC')
            ->limit($pagination->limit)
            ->asArray()->all();

        $apply = Treatapply::find(['id', 'treatid', 'user_name', 'id_number', 'remark', 'applystatus'])
            ->where(['user_id' => $uid])->asArray()->all();

        $cateids = array();
        foreach ($model as $vi) {
            $cateids[] = $vi['id'];
        }

        $templateinfo = Treattemplate::find()->select(['id', 'treatid', 'isrequired', 'filetemplateurl', 'templatename'])->where(['in', 'treatid', $cateids])
            ->asArray()->all();

        $applyids = array();
        foreach ($apply as $v) {
            $applyids[] = $v['id'];
        }

        $applyfiles = TreatApplyFiles::find()->where(['in', 'treatapplyid', $applyids])
            ->asArray()->all();

        foreach ($model as $key => $value) {
            if ($value['treattype'] == \Yii::$app->params['talent.treat.applytype']) {
                foreach ($templateinfo as $info) {
                    if (isset($info['treatid']) && $value['id'] == $info['treatid']) {
                        if (!empty($info['filetemplateurl'])) {
                            $temp = \Yii::$app->request->getHostInfo() . $info['filetemplateurl'];
                        } else {
                            $temp = null;
                        }
                        if ($info['isrequired'] == 1) {
                            $model[$key]['require'][] = array(
                                'filetemplateurl' => $temp,
                                'templateid' => $info['id'],
                                'templatename' => $info['templatename'],
                            );
                        } else {
                            $model[$key]['optional'][] = array(
                                'filetemplateurl' => $temp,
                                'templateid' => $info['id'],
                                'templatename' => $info['templatename'],
                            );
                        }
                    }
                }
                foreach ($apply as $item) {
                    if (isset($item['treatid']) && $value['id'] == $item['treatid']) {
                        $model[$key]['treatapplyid'] = $item['id'];
                        $model[$key]['user_name'] = $item['user_name'];
                        $model[$key]['id_number'] = $item['id_number'];
                        $model[$key]['remark'] = $item['remark'];
                        $model[$key]['applystatus'] = $item['applystatus'];
                        foreach ($applyfiles as $filesign) {
                            if ($filesign['treatapplyid'] == $item['id']) {
                                $model[$key]['uploads'][] = array(
                                    'fileurl' => \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $filesign['filesign'],
                                    'filesign' => $filesign['filesign'],
                                    'templateid' => $filesign['templateid'],
                                );
                            }
                        }
                        $model[$key]['status_name'] = \Yii::$app->params['talent.applystatusname'][$item['applystatus']];
                    } else {
                        //$model[$key]['applystatus'] = \Yii::$app->params['talent.applystatus']['noapply'];
                        $model[$key]['user_name'] = $talentinfo['user_name'];
                        $model[$key]['id_number'] = $talentinfo['id_number'];
                    }
                }
            } else {
                $model[$key]['status_name'] = '立即查看';
            }
            $model[$key]['treatlevel'] = $value['treatlevel'];
        }

        foreach ($model as $key => $value) {
            if (isset($model[$key]['uploads'])) {
                foreach ($model[$key]['uploads'] as $k1 => $v1) {
                    if (isset($model[$key]['require'])) {
                        foreach ($model[$key]['require'] as $k2 => $v2) {
                            if ($v2['templateid'] == $v1['templateid']) {
                                $model[$key]['require'][$k2]['filesign'] = $v1['filesign'];
                                $model[$key]['require'][$k2]['fileurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $v1['filesign'];
                            }
                        }
                    }
                    if (isset($model[$key]['optional'])) {
                        foreach ($model[$key]['optional'] as $k3 => $v3) {
                            if ($v3['templateid'] == $v1['templateid']) {
                                $model[$key]['optional'][$k3]['filesign'] = $v1['filesign'];
                                $model[$key]['optional'][$k3]['fileurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $v1['filesign'];
                            }
                        }
                    }
                }
            }
            unset($model[$key]['uploads']);
        }
        if (!isset($model[$key]['status_name'])) {
            $model[$key]['status_name'] = \Yii::$app->params['talent.applystatusname'][0];
        }


        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
}