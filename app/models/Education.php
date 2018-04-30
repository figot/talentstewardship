<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $school
 * @property string $institute
 * @property string $degree
 * @property string $vcode
 * @property string $degreereport
 * @property string $graduation_year
 * @property string $certificate
 * @property string $diploma
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief 教育经历信息
 */

class Education extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%education}}';
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
            [['id', 'school', 'institute', 'degree', 'graduation_year', 'certificate', 'diploma', 'vcode', 'degreereport'], 'trim'],
            [['id'], 'number'],
            ['degree', 'in', 'range' => ['博士后','博士','硕士','本科','专科','专科以下']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'school' => '学校',
            'institute' => '学院',
            'degree' => '学历',
            'graduation_year' => '毕业年份',
            'certificate' => '学位证书',
            'diploma' => '学历证书',
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
    public static function findInfoByUid($id)
    {
        return static::findAll(['user_id' => $id, 'status' => 1]);
    }
    /**
     * @inheritdoc
     */
    public function saveData($id) {
        $this->user_id = $id;
        $education = Education::find()->where(['user_id' => intval($this->user_id)])->one();
        if ($education !== null) {
            $eid = $education->id;
            $education->attributes = $this->attributes;
            $education->id = $eid;
            if (!$education->save(false)) {
                throw new \Exception();
            }
        } else {
            if (!$this->save(false)) {
                throw new \Exception();
            }
        }
        return true;
    }
    /**
     *
     * @return
     */
    public function getData($id)
    {
        $education = Education::find()->where(['user_id' => $id])->orderBy('id DESC')->asArray()->all();
        foreach ($education as $key => $item) {
            $education[$key]['certificate'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $item['certificate'];
            $education[$key]['diploma'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $item['diploma'];
        }
        return $education;
    }
    /**
     *
     * @return 获取最高学历
     */
    public function getEducationByLast($id)
    {
        $education = Education::find()->where(['user_id' => $id])->orderBy('graduation_year DESC')->one();
        return $education;
    }
    /**
     *
     * @return 获取最高学历
     */
    public static function authEducation($edu) {
        if (strpos($edu['degreereport'], $edu['school']) === FALSE) {
            return false;
        }
        if (strpos($edu['degreereport'], $edu['degree']) === FALSE) {
            return false;
        }
        return true;
    }
}