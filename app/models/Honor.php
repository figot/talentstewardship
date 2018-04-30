<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $year
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 人才认证，个人荣誉信息
 */

class Honor extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%honor}}';
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
            [['name', 'year'], 'trim'],
            [['year'], 'match', 'pattern' => '/^[0-9]{4}$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '人才名称',
            'year' => '评选年份',
        ];
    }
    /**
     *
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['access_token' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (empty($this->status)) {
                    $this->status = 1;
                }
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => 1]);
    }

    /**
     * @inheritdoc
     */
    public function saveData($id) {
        $this->user_id = $id;
        $honor = Honor::findIdentity(intval($this->id));
        if ($honor !== null) {
            $honor->attributes = $this->attributes;
            if (!$honor->save(false)) {
                throw new \Exception();
            }
            $honorid = $honor->attributes['id'];
        } else {
            if (!$this->save(false)) {
                throw new \Exception();
            }
            $honorid = $this->attributes['id'];
        }
        return $honorid;
    }
    /**
     * @return
     */
    public function getData($id)
    {
        $query = Honor::find()
            ->where(['honor.user_id' => $id, 'honor.status' => 1]);

        $query->joinWith('honorfiles');

        $model = $query->select(['honor.id', 'honor.name',  'honor.year', 'honorfiles.honorid', 'honorfiles.filesign'])
            ->asArray()->all();

        foreach ($model as $key => $value) {
            foreach ($value['honorfiles'] as $filesign) {
                if ($filesign['honorid'] == $value['id']) {
                    $model[$key]['fileurls'][] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $filesign['filesign'];
                }
            }
            if (isset($model[$key]['honorfiles'])) {
                unset($model[$key]['honorfiles']);
            }
            if (isset($model[$key]['filesign'])) {
                unset($model[$key]['filesign']);
            }
        }
        return $model;
    }
    /**
     * @inheritdoc
     */
    public function getHonorfiles()
    {
        return $this->hasMany(Honorfiles::className(), ['honorid' => 'id']);
    }
}