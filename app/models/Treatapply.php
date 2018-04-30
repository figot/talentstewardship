<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property string $treatid
 * @property string $user_name
 * @property string $id_number
 * @property string $remark
 * @property string $applystatus
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Treatapply extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%treatmentapply}}';
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
            [['treatid', 'user_name', 'id_number', 'remark'], 'trim'],
            [['id_number'], 'match', 'pattern' => '/(^\d{15}$)|(^\d{17}([0-9]|X)$)/'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function saveData($uid) {
        $this->user_id = $uid;
        $this->applystatus = \Yii::$app->params['talent.applystatus']['apply'];
        $apply = Treatapply::findIdentity($this->treatid, $this->user_id);
        if ($apply !== null) {
            $apply->attributes = $this->attributes;
            if (!$apply->save(false)) {
                throw new \Exception();
            }
            $applyid = $apply->attributes['id'];
        } else {
            if (!$this->save(false)) {
                throw new \Exception();
            }
            $applyid = $this->attributes['id'];
        }
        return $applyid;
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id, $uid)
    {
        return static::findOne(['treatid' => $id, 'user_id' => $uid]);
    }

    /**
     *
     * @return
     */
    public function getData($pn, $rn)
    {
        $treat = Treatapply::find()->select(['id', 'title', 'content'])->where(['status' => \Yii::$app->params['talent.status']['published']])->limit($rn)->offset($rn*$pn)->all();

        return $treat;
    }
    /**
     *
     * @return
     */
    public function getByUid($uid)
    {
        $apply = Treatapply::find()->select(['id', 'treatid', 'applystatus', 'user_name', 'id_number', 'remark'])->where(['user_id' => $uid])->asArray()->all();

        $treatids = array();
        foreach ($apply as $key => $value) {
            $treatids[] = $value['treatid'];
        }
        $treat = Treatment::find()->select(['id', 'title', 'url', 'brief'])->where(['in', 'id', $treatids])->asArray()->all();

        $template = Treattemplate::find()->where(['in', 'treatid', $treatids])->asArray()->all();

        $applyids = array();
        foreach ($apply as $v) {
            $applyids[] = $v['id'];
        }

        $applyfiles = TreatApplyFiles::find()->where(['in', 'treatapplyid', $applyids])
            ->asArray()->all();

        $protemp = array();
        foreach ($treat as $k => $item) {
            foreach ($template as $info) {
                if (!empty($info['filetemplateurl'])) {
                    $temp = \Yii::$app->request->getHostInfo() . $info['filetemplateurl'];
                } else {
                    $temp = null;
                }
                $filetemp = array();
                foreach ($applyfiles as $filesign) {
                    if ($filesign['templateid'] == $info['id'] && !empty($filesign['filesign'])) {
                        $filetemp = array(
                            'fileurl' => \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $filesign['filesign'],
                            'filesign' => $filesign['filesign'],
                        );
                    }
                }
                if ($info['isrequired'] == 1) {
                    $applytemp[$item['id']]['require'][] = array(
                        'filetemplateurl' => $temp,
                        'templateid' => $info['id'],
                        'templatename' => $info['templatename'],
                        'fileurl' => empty($filetemp) ? null : $filetemp['fileurl'],
                        'filesign' => empty($filetemp) ? null : $filetemp['filesign'],
                    );
                } else {
                    $applytemp[$item['id']]['optional'][] = array(
                        'filetemplateurl' => $temp,
                        'templateid' => $info['id'],
                        'templatename' => $info['templatename'],
                        'fileurl' => empty($filetemp) ? null : $filetemp['fileurl'],
                        'filesign' => empty($filetemp) ? null : $filetemp['filesign'],
                    );
                }
            }
        }

        foreach ($treat as $key => $value) {
            foreach ($apply as $k => $item) {
                if ($value['id'] == $item['treatid']) {
                    $treat[$key]['status_name'] = \Yii::$app->params['talent.applystatusname'][$item['applystatus']];
                    $treat[$key]['user_name'] = $item['user_name'];
                    $treat[$key]['applystatus'] = $item['applystatus'];
                    $treat[$key]['id_number'] = $item['id_number'];
                    $treat[$key]['remark'] = $item['remark'];
                    foreach ($template as $info) {
                        if (isset($info['treatid']) && $item['treatid'] == $info['treatid']) {
                            foreach ($applytemp as $k1 => $v1) {
                                if ($k1 == $item['treatid']) {
                                    if (isset($v1['require'])) {
                                        $treat[$key]['require'] = $v1['require'];
                                    }
                                    if (isset($v1['optional'])) {
                                        $treat[$key]['optional'] = $v1['optional'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $cnt = Treatment::find()->where(['in', 'id', $treatids])->count();
        $arrRes = ['list' => $treat, 'total' => $cnt];

        return $arrRes;
    }
}