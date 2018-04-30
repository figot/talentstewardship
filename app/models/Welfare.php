<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\talentinfo;
use yii\helpers\ArrayHelper;

/**
 *
 * @property integer $user_id
 * @property string $job
 * @property string $user_name
 * @property string $gender
 * @property string $id_number
 * @property string $talentlevel
 * @property string $weltype
 * @property string $applytype
 * @property string $content
 * @property string $status
 * @property string $file
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Welfare extends ActiveRecord
{
    //public $talentinfo;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%welfare}}';
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

    public function getTalentinfo()
    {
        return $this->hasOne(Talentinfo::className(), ['user_id' => 'id'])->select(['user_name', 'gender', 'id_number']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job', 'user_name', 'gender', 'id_number', 'tlevel', 'content', 'file', 'weltype', 'applytype'], 'trim'],

            [['id_number'], 'match', 'pattern' => '/(^\d{15}$)|(^\d{17}([0-9]|X)$)/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'job' => '职位',
            'user_name' => '用户名',
            'gender' => '性别',
            'id_number' => '身份证号',
            'tlevel' => '人才级别',
            'weltype' => '享受级别',
            'applytype' => '申报级别',
            'content' => '申报内容',
            'file' => '申报上传文件',
            'status' => '状态',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
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
        return static::findOne(['user_id' => $id]);
    }
    /**
     * @inheritdoc
     */
    public function saveData($id) {
        $this->user_id = $id;
        $welfare = Welfare::findIdentity($this->user_id);
        if ($welfare !== null) {
            $welfare->attributes = $this->attributes;
            if (!$welfare->save(false)) {
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
        $this->user_id = $id;
        $welfare = Welfare::findOne(['user_id' => $this->user_id]);
        return $welfare;
    }
//    /**
//     *
//     * @return
//     */
//    public function getData($id)
//    {
//        $this->user_id = $id;
//        $welfare = Welfare::findOne(['user_id' => $this->user_id]);
//        if (empty($welfare)) {
//            return false;
//        }
//        $talentinfo = $welfare->talentinfo;
//        $welfareRes = ArrayHelper::toArray($welfare, [
//            'app\models\Welfare' => [
//                'id',
//                'weltype',
//                'applytype',
//                'content',
//            ],
//        ]);
//        $talentRes = ArrayHelper::toArray($talentinfo, [
//            'app\models\Talentinfo' => [
//                'user_name',
//                'id_number',
//                'gender',
//            ],
//        ]);
//        $res = ArrayHelper::merge($welfareRes, $talentRes);
//        return $res;
//    }
}