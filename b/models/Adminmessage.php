<?php

namespace b\models;

use b\models\Depart;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @brief  消息
 */

class Adminmessage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%adminmessage}}';
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
            [['title', 'content', 'status', 'url', 'msgtype', 'area', 'department'], 'trim'],
            [['title', 'content', 'status', 'url', 'msgtype'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '消息标题',
            'content' => '消息内容',
            'status' => '消息状态',
            'url' => '消息地址'
        ];
    }
    /**
     *
     * @return ActiveDataProvider
     */
    public function search($params, $userauth=null, $hotelauth=null)
    {
        $query = Adminmessage::find();
        if (empty($userauth) && empty($hotelauth)) {
            $query->orWhere(['id' => -1]);
        }

        if (!empty($userauth)) {
            if ($userauth->isroot == \Yii::$app->params['adminuser.rootlevelstatus']['root']) {
                $query->orWhere(['msgtype' => 2]);
            } else if ($userauth->isroot == \Yii::$app->params['adminuser.rootlevelstatus']['subroot']) {
                $depart = Depart::find()->where(['id' => $userauth->subdepartid])->one();
                $query->orWhere(['and', ['msgtype' => 2], ['department' => $depart->subdepart]]);
            }
        }

        if (!empty($hotelauth)) {
            if ($hotelauth->isroot == \Yii::$app->params['adminuser.rootlevelstatus']['root']) {
                $query->orWhere(['msgtype' => 1]);
            } else if ($hotelauth->isroot == \Yii::$app->params['adminuser.rootlevelstatus']['subroot']) {
                $query->orWhere(['and', ['msgtype' => 1], ['area' => $hotelauth['hotelarea']]]);
            } else if ($hotelauth->isroot == \Yii::$app->params['adminuser.rootlevelstatus']['current']) {
                $query->orWhere(['and', ['msgtype' => 1], ['id' => -1]]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->orderBy([
            'status' => SORT_ASC,
            'id'=> SORT_DESC
        ]);

        return $dataProvider;
    }
}