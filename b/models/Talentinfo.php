<?php

namespace b\models;

use b\models\Education;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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

        ];
    }

    /**
     * @brief
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
     * @brief
     */
    public static function getInfo($uid) {
        $talent = Talentinfo::find()->where(['user_id' => $uid])->asArray()->one();
        $education = Education::getInfo($uid);
        if (!isset($talent['idcarddown'])) {
            $talent['idcarddown'] = '';
        }
        if (!isset($talent['idcardup'])) {
            $talent['idcardup'] = '';
        }
        if (!isset($talent['certificate'])) {
            $talent['certificate'] = '';
        }
        if (!isset($talent['diploma'])) {
            $talent['diploma'] = '';
        }
        $education['certificateurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $education['certificate'];
        $education['diplomaurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $education['diploma'];
        $talent['idcardupurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $talent['idcardup'];
        $talent['idcarddownurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $talent['idcarddown'];
        $talent['education'] = $education;
        \Yii::warning('===============' . var_export($talent, true));
        return $talent;
    }
}