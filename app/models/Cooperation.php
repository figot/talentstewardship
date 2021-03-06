<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $ctype
 * @property int $status
 * @property string $title
 * @property string $content
 * @property string $url
 * @property int $release_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Cooperation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cooperation';
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
            [['title', 'content', 'ctype'], 'trim'],

            [['ctype', 'title', 'content'], 'required'],
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
                    $this->status = 2;
                }
                $this->url = \Yii::$app->params['h5urlprefix'] . 'coop?id=';
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
            'title' => '标题',
            'content' => '内容',
        ];
    }
    /**
     *
     * @return
     */
    public function get($rn, $pn, $type=null)
    {
        if ($type == null) {
            $query = Cooperation::find(['id','ctype', 'url', 'title', 'release_time'])
                ->where(['status' => \Yii::$app->params['talent.status']['published']]);
        } else {
            $query = Cooperation::find(['id', 'title', 'url', 'release_time'])
                ->where(['ctype' => $type, 'status' => \Yii::$app->params['talent.status']['published']]);
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
            $model[$key]['url'] = $value['url'] . $value['id'];
        }

        $arrRes = ['list' => $model, 'total' => $count];

        return $arrRes;
    }
}