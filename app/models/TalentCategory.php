<?php
namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property string $talentlevel
 * @property integer $status
 *
 */

class TalentCategory extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentcategory}}';
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
            [['id', 'talentlevel'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'talentlevel' => '人才分类的级别名称',
        ];
    }
    /**
     *
     * @return
     */
    public function get($rn, $pn, $uid)
    {
        $query = TalentCategory::find()->where(['status' => 2, 'authmethod' => \Yii::$app->params['talent.catestatus']['talentauth']])
            ->select(['id', 'talentlevel', 'talentcondition']);

        $count = $query->count();

        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $rn,
        ]);
        $pagination->setPage($pn);

        $model = $query->offset($pagination->offset)
            ->orderBy('id DESC')
            ->limit($pagination->limit)
            ->asArray()->all();

        $apply = Talentapply::find(['id', 'talentcategoryid', 'templateid', 'remark', 'applystatus'])
            ->where(['user_id' => $uid])->asArray()->all();

        $applyids = array();
        foreach ($apply as $v) {
            $applyids[] = $v['id'];
        }

        $cateids = array();
        foreach ($model as $vi) {
            $cateids[] = $vi['id'];
        }

        $talentinfo = Talentfiles::find()->select(['id', 'talentcategoryid', 'isrequired', 'filetemplateurl', 'templatename'])->where(['in', 'talentcategoryid', $cateids])
            ->asArray()->all();

        $applyfiles = TalentApplyfiles::find()->where(['in', 'talentapplyid', $applyids])
            ->asArray()->all();

        foreach ($model as $key => $value) {
            foreach ($talentinfo as $info) {
                if (isset($info['talentcategoryid']) && $value['id'] == $info['talentcategoryid']) {
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
                if (isset($item['talentcategoryid']) && $value['id'] == $item['talentcategoryid']) {
                    $model[$key]['talentapplyid'] = $item['id'];
                    $model[$key]['remark'] = $item['remark'];
                    $model[$key]['applystatus'] = $item['applystatus'];
                    $model[$key]['status_name'] = \Yii::$app->params['talent.authstatusname'][$item['applystatus']];
                    $model[$key]['reason'] = $item['reason'];
                    foreach ($applyfiles as $filesign) {
                        if ($filesign['talentapplyid'] == $item['id']) {
                            $model[$key]['uploads'][] = array(
                                'fileurl' => \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $filesign['filesign'],
                                'filesign' => $filesign['filesign'],
                                'templateid' => $filesign['templateid'],
                            );
                        }
                    }
                }
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
        }


        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
}