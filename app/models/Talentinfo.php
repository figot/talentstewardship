<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\TalentCategory;

use app\models\Talentcard;
use app\models\Experience;

/**
 *
 * @property integer $user_id
 * @property string $mobile
 * @property string $user_name
 * @property string $gender
 * @property string $id_number
 * @property string $pol_visage
 * @property string $address
 * @property string $email
 * @property string $qq
 * @property string $wechat
 * @property string $brief
 * @property string $portrait
 * @property integer $status
 * @property string $good_fields
 *
 */

class Talentinfo extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talentinfo}}';
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
            [['mobile', 'user_name', 'gender', 'id_number', 'pol_visage', 'address', 'email', 'qq', 'wechat', 'brief', 'portrait', 'good_fields', 'idcardup', 'idcarddown'], 'trim'],
            [['mobile', 'user_name', 'id_number'], 'required'],
            ['email', 'email'],
            [['mobile'], 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]{9}$/'],
            [['id_number'], 'match', 'pattern' => '/(^\d{15}$)|(^\d{17}([0-9]|X)$)/'],
            ['qq', 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_name' => '人才名称',
            'gender' => '性别',
            'id_number' => '身份证号',
            'pol_visage' => '政治面貌',
            'address' => '地址',
            'email' => '邮箱',
            'qq' => 'qq',
            'wechat' => '微信',
            'brief' => '个人简介',
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
        return static::findOne(['user_id' => $id, 'status' => 1]);
    }
    /**
     * @inheritdoc
     */
    public function saveData($id) {
        $this->user_id = $id;
        $talent = Talentinfo::findIdentity($this->user_id);
        if ($talent !== null) {
            $talent->attributes = $this->attributes;
            if (!$talent->save()) {
                throw new \Exception();
            }
        } else {
            $this->authstatus = \Yii::$app->params['talent.authstatus']['unauth'];
            if (!$this->save()) {
                throw new \Exception();
            }
        }
        return true;
    }
    /**
     * @inheritdoc
     */
    public function saveMaxDegree($id, $degree) {
        $this->user_id = $id;
        $edu = array();
        $pretalent = TalentCategory::find(['id', 'educate', 'talentlevel'])->where(['authmethod' => \Yii::$app->params['talent.catestatus']['eduauth']])->asArray()->all();
        foreach ($pretalent as $v) {
            $edu[$v['educate']] = $v['id'];
        }
        $talent = Talentinfo::findIdentity($this->user_id);
        if ($talent !== null) {
            $talent->maxdegree = $degree;
            if ($degree == '博士' || $degree == '博士后') {
                if (isset($edu[$degree])) {
                    $talent->category = $edu[$degree];
                }
                $talent->catestatus = \Yii::$app->params['talent.catestatus']['eduauth'];
                $talent->authstatus = \Yii::$app->params['talent.authstatus']['authsuccess'];
            } else if ($degree == '硕士') {
                if (isset($edu[$degree])) {
                    $talent->category = $edu[$degree];
                }
                $talent->catestatus = \Yii::$app->params['talent.catestatus']['eduauth'];
                $talent->authstatus = \Yii::$app->params['talent.authstatus']['authsuccess'];
            } else if ($degree == '本科') {
                if (isset($edu[$degree])) {
                    $talent->category = $edu[$degree];
                }
                $talent->catestatus = \Yii::$app->params['talent.catestatus']['eduauth'];
                $talent->authstatus = \Yii::$app->params['talent.authstatus']['authsuccess'];
            } else if ($degree == '专科') {
                if (isset($edu[$degree])) {
                    $talent->category = $edu[$degree];
                }
                $talent->catestatus = \Yii::$app->params['talent.catestatus']['eduauth'];
                $talent->authstatus = \Yii::$app->params['talent.authstatus']['authsuccess'];
            }
            else {
                $talent->authstatus = \Yii::$app->params['talent.authstatus']['authing'];
            }
            if (!$talent->save(false)) {
                throw new \Exception();
            }
        }
        return true;
    }
    /**
     *
     * @return
     */
    public function getTalentcard()
    {
        return $this->hasOne(Talentcard::className(), ['id' => 'user_id']);
    }
    /**
     *
     * @return
     */
    public function getExperience()
    {
        return $this->hasMany(Experience::className(), ['id' => 'user_id']);
    }
    /**
     *
     * @return
     */
    public function getData($id)
    {
        $this->user_id = $id;
        $talent = Talentinfo::findIdentity($this->user_id);
        return $talent;
    }
    /**
     *
     * @return
     */
    public function getTalentList($pn, $rn, $type)
    {
        $model = Talentinfo::find()->where(['category' => $type, 'isshow' => \Yii::$app->params['talent.showinfo']['shown']])->orderBy('id DESC')->limit($rn)->offset($rn*$pn)->asArray()->all();

        return $model;
    }
}