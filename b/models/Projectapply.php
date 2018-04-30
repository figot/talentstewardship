<?php

namespace b\models;

use b\models\Talentinfo;
use b\models\Projectapplyfiles;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property int $user_id
 * @property string $projectid
 * @property string $templateid
 * @property string $applystatus
 * @property string $remark
 * @property string $reason
 * @property string $applytime
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Projectapply extends ActiveRecord
{
    public $user_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%projectapply}}';
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
            [['applystatus', 'reason'], 'trim'],
        ];
    }
    public function getTalentinfo()
    {
        return $this->hasOne(Talentinfo::className(), ['user_id' => 'user_id']);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applystatus' => '申请状态',
            'reason' => '审核意见',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function getApplyFiles($applyid, $projectid)
    {
        $arrRes = array(
            'require' => array(),
            'optional' => array(),
        );
        $template = Projecttemplate::find()->where(['projectid' => $projectid])->asArray()->all();
        $applyfiles = Projectapplyfiles::find()->where(['projectapplyid' => $applyid])->asArray()->all();
        if (!empty($applyfiles)) {
            foreach ($applyfiles as $key => $item) {
                $applyfiles[$key]['imgurl'] = \Yii::$app->request->getHostInfo() . '/app/web/img/get?sign=' . $item['filesign'];
                foreach ($template as $temp) {
                    if ($temp['id'] == $item['templateid']) {
                        $applyfiles[$key]['isrequired'] = 1;
                    }
                }
            }
            foreach ($applyfiles as $k => $v) {
                if ( isset($v['isrequired']) && $v['isrequired'] == 1) {
                    $arrRes['require'][] = $v;
                } else {
                    $arrRes['optional'][] = $v;
                }
            }
        }
        return $arrRes;
    }
}