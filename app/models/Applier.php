<?php

namespace app\models;

use b\models\Experience;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property int $status
 * @property int $atype
 * @property string $tlevel
 * @property string $title
 * @property string $content
 * @property string $job
 * @property int $company
 * @property string $suit_per
 * @property string $suit_area
 * @property string $portrait
 * @property integer $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Applier extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applier';
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
            [['pn', 'rn', ], 'trim'],
            [['pn', 'rn'], 'required'],

            [['pn', 'rn'], 'integer'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (empty($this->status)) {
                    $this->status = 2;
                }
                $this->release_time = time();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function saveData($id) {
        $this->user_id = $id;
        if (!$this->save(false)) {
            throw new \Exception();
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'atype' => '自荐、荐才',
            'tlevel' => '人才类别',
            'job' => '曾任职位',
            'company' => '曾任单位',
            'title' => '招聘标题',
            'content' => '招聘内容',
            'suit_per' => '招聘职位',
            'suit_area' => '福利',
            'portrait' => '招聘单位',
            'release_time' => '发布时间',
        ];
    }

    /**
     *
     * @return
     */
    public function get($rn, $pn, $type=null)
    {
        $query = Applier::find(['id', 'tlevel','applier_name', 'job','company','title','content', 'portrait', 'url', 'good_fields'])
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

        foreach ($model as $key => $value) {
            $model[$key]['url'] = $value['url'] . $value['id'];
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
    /**
     *
     * @return
     */
    public function getDetail($id)
    {
        $query = Applier::find(['tlevel','applier_name', 'job','company','title','content', 'portrait', 'url', 'good_fields', 'user_id'])
            ->where(['status' => \Yii::$app->params['talent.status']['published'], 'id' => $id])->asArray()->one();

        $talent = Talentinfo::find()->select(['maxdegree', 'gender', 'email',])->where(['user_id' => $query['user_id']])->asArray()->one();

        if (empty($talent)) {
            $talent = array();
        }
        if (empty($query)) {
            $query = array();
        }
        $talentinfo = array_merge($query, $talent);
        if (empty($talentinfo)) {
            return false;
        }

        $talentinfo['work'] = Experience::find()->where(['user_id' => $query['user_id']])->asArray()->all();


        return $talentinfo;
    }
}