<?php

namespace app\models;
use app\models\Project;
use b\models\Projecttemplate;
use yii\data\Pagination;
use app\models\ProjectApplyFiles;
use yii\behaviors\TimestampBehavior;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property int $projectid
 * @property int $applystatus
 * @property int $remark
 * @property int $applytime
 * @property integer $created_at
 * @property integer $updated_at
 */
class Projectapply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projectapply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
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
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (empty($this->applystatus)) {
                    $this->applystatus = 1;
                }
                $this->applytime = time();
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'projectid']);
    }
    /**
     * @inheritdoc
     */
    public function getProjectapplyfiles()
    {
        return $this->hasMany(ProjectApplyFiles::className(), ['projectapplyid' => 'id']);
    }

    /**
 *
 * @return
 */
    public function get($rn, $pn, $uid, $type=null)
    {
        $query = Projectapply::find()
            ->where(['projectapply.user_id' => $uid]);

        $query->joinWith('project');
        $query->joinWith('projectapplyfiles');
        $model = $query->select(['projectapply.id', 'projectapply.projectid', 'projectapply.applystatus','project.title','project.brief', 'projectapply.remark', 'projectapply.applytime'])
            ->orderBy('projectapply.applytime DESC')
            ->asArray()->all();
        $count = Projectapply::find()->where(['user_id' => $uid])->count();


//        $pagination = new Pagination([
//            'totalCount' => $count,
//            'pageSize' => $rn,
//        ]);
//        $pagination->setPage($pn);
//
//        $model = $query->offset($pagination->offset)
//            ->orderBy('release_time DESC')
//            ->limit($pagination->limit)
//            ->asArray()->all();

        foreach ($model as $key => $value) {
            //$model[$key]['url'] = $value['url'] . $value['projectid'];
            if (isset($value['applystatus'])) {
                $applystatus = intval($value['applystatus']);
                $model[$key]['status_name'] = \Yii::$app->params['talent.applystatusname2'][$applystatus];
            }
            foreach ($value['projectapplyfiles'] as $filesign) {
                if ($filesign['projectapplyid'] == $value['id']) {
                    $model[$key]['fileurls'][] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $filesign['filesign'];
                }
            }
            if (isset($model[$key]['project'])) {
                unset($model[$key]['project']);
            }
            if (isset($model[$key]['projectapplyfiles'])) {
                unset($model[$key]['projectapplyfiles']);
            }
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }

    /**
     *
     * @return
     */
    public function getInfo($uid, $projectid)
    {
        $query = Projectapply::find()
            ->where(['user_id' => $uid, 'projectid' => $projectid])->one();

        $project = Project::find()->where(['id' => $projectid])->one()->toArray();

        $template = Projecttemplate::find()->where(['projectid' => $projectid])->asArray()->all();

        if (empty($query)) {
            $query['projectid'] = $project['id'];
            if (!empty($project['jumpurl'])) {
                $query['url'] = $project['jumpurl'];
            } else {
                $query['url'] = $project['url'];
            }
            $query['title'] = $project['title'];

            foreach ($template as $key => $value) {
                if (!empty($value['filetemplateurl'])) {
                    $temp = \Yii::$app->request->getHostInfo() . $value['filetemplateurl'];
                } else {
                    $temp = null;
                }
                if ($value['isrequired'] == 1) {
                    $query['require'][] = array(
                        'filetemplateurl' => $temp,
                        'templateid' => $value['id'],
                        'templatename' => $value['templatename'],
                    );
                } else {
                    $query['optional'][] = array(
                        'filetemplateurl' => $temp,
                        'templateid' => $value['id'],
                        'templatename' => $value['templatename'],
                    );
                }
            }
        } else {
            $query = $query->toArray();
            if (!empty($project['jumpurl'])) {
                $query['url'] = $project['jumpurl'];
            } else {
                $query['url'] = $project['url'];
            }
            $query['title'] = $project['title'];

            $tempids = array();
            foreach ($template as $v) {
                $tempids[] = $v['id'];
            }

            $applyfiles = ProjectApplyFiles::find()
                ->andWhere(['in', 'templateid', $tempids])
                ->andWhere(['user_id' => $uid])->asArray()->all();

            foreach ($template as $key => $value) {
                if (!empty($value['filetemplateurl'])) {
                    $temp = \Yii::$app->request->getHostInfo() . $value['filetemplateurl'];
                } else {
                    $temp = null;
                }
                if ($value['isrequired'] == 1) {
                    $query['require'][] = array(
                        'filetemplateurl' => $temp,
                        'templateid' => $value['id'],
                        'templatename' => $value['templatename'],
                    );
                } else {
                    $query['optional'][] = array(
                        'filetemplateurl' => $temp,
                        'templateid' => $value['id'],
                        'templatename' => $value['templatename'],
                    );
                }
            }

            foreach ($applyfiles as $filesign) {
                $query['uploads'][] = array(
                    'fileurl' => \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $filesign['filesign'],
                    'filesign' => $filesign['filesign'],
                    'templateid' => $filesign['templateid'],
                );
            }

            if (isset($query['uploads'])) {
                foreach ($query['uploads'] as $k1 => $v1) {
                    if (isset($query['require'])) {
                        foreach ($query['require'] as $k2 => $v2) {
                            if ($v2['templateid'] == $v1['templateid']) {
                                $query['require'][$k2]['filesign'] = $v1['filesign'];
                                $query['require'][$k2]['fileurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $v1['filesign'];
                            }
                        }
                    }
                    if (isset($query['optional'])) {
                        foreach ($query['optional'] as $k3 => $v3) {
                            if ($v3['templateid'] == $v1['templateid']) {
                                $query['optional'][$k3]['filesign'] = $v1['filesign'];
                                $query['optional'][$k3]['fileurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $v1['filesign'];
                            }
                        }
                    }
                }
            }
            unset($query['uploads']);
        }



        return $query;
    }

    /**
     *
     * @return 获取我的项目列表
     */
    public function getMyProject($rn, $pn, $uid, $type=null)
    {
        $model = Projectapply::find()->select(['id', 'projectid', 'applystatus', 'remark', 'applytime', 'reason'])
            ->where(['user_id' => $uid])->orderBy('applytime DESC')
            ->asArray()->all();

        $projectids = array();
        foreach ($model as $v) {
            $projectids[] = $v['projectid'];
        }

        $template = Projecttemplate::find()->where(['in', 'projectid', $projectids])->asArray()->all();
        $project = Project::find()->where(['in', 'id', $projectids])->asArray()->all();

        $applyids = array();
        foreach ($model as $v) {
            $applyids[] = $v['id'];
        }

        $applyfiles = ProjectApplyFiles::find()->where(['in', 'projectapplyid', $applyids])
            ->asArray()->all();

        $count = Projectapply::find()->where(['user_id' => $uid])->count();

        $protemp = array();
        foreach ($project as $k => $item) {
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

        foreach ($model as $key => $value) {
            if (isset($value['applystatus'])) {
                $applystatus = intval($value['applystatus']);
                $model[$key]['status_name'] = \Yii::$app->params['talent.applystatusname2'][$applystatus];
            }
            foreach ($project as $k => $item) {
                foreach ($template as $info) {
                    if (isset($info['projectid']) && $item['id'] == $info['projectid']) {
                        $model[$key]['title'] = $item['title'];
                        $model[$key]['brief'] = $item['brief'];
                        foreach ($applytemp as $k1 => $v1) {
                            if ($k1 == $item['id']) {
                                if (isset($v1['require'])) {
                                    $model[$key]['require'] = $v1['require'];
                                }
                                if (isset($v1['optional'])) {
                                    $model[$key]['optional'] = $v1['optional'];
                                }
                            }
                        }
                    }
                }
            }
        }


        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }

    /**
     * @inheritdoc
     */
    public function saveData($id, $uid, $remark) {
        $this->user_id = $uid;
        $this->projectid = $id;
        $this->remark = $remark;
        $apply = Projectapply::findOne(['projectid' => $id, 'user_id' => $uid]);
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
}