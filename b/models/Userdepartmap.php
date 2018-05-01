<?php

namespace b\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;
use common\models\AdminModel;

/**
 *
 * @property integer $id
 * @property string $educate
 * @property string $talentlevel
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  用户机构对应关系
 */

class Userdepartmap extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%userdepartmap}}';
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
            [['user_id', 'subdepartid'], 'trim'],
            [['user_id', 'subdepartid'], 'required'],
            [['user_id'], 'unique', 'message' => '该用户已经有了从属机构，请先删除']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户名称',
            'subdepartid' => '用户所属机构',
        ];
    }
    public function getDepart()
    {
        return $this->hasOne(Depart::className(), ['id' => 'subdepartid']);
    }
    public function getAdmin()
    {
        return $this->hasOne(AdminModel::className(), ['id' => 'user_id']);
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Userdepartmap::find();
        $query->joinWith('depart');
        $query->joinWith('admin');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
    public static function getUserinfo() {
        $arrRes = array();
        $user = AdminModel::find()->select(['id', 'username'])->asArray()->all();
        foreach ($user as $k => $v) {
            $arrRes[$v['id']] = $v['username'];
        }
        return $arrRes;
    }
}