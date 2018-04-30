<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property string $department
 * @property int $status
 * @property string $title
 * @property string $content
 * @property string $job
 * @property string $welfare
 * @property int $company
 * @property string $attibute
 * @property string $salary
 * @property integer $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Recruit extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recruit';
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
            [['title', 'content', 'job'], 'trim'],

            [['type', 'title', 'content'], 'required'],
            ['ctype', 'in', 'range' => [1, 2, 3, 4]],

            [['ctype'], 'number'],
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
                    $this->status = 4;
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
     *
     * @return
     */
    public function get($rn, $pn, $type=null)
    {
        $query = Recruit::find(['id','department','title','job','welfare','company','attibute','salary', 'url', 'release_time'])
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
}