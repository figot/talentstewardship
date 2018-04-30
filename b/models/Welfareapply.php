<?php

namespace b\models;

use app\models\Welfare;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 *
 * @property integer $id
 * @property string $treatid
 * @property string $user_name
 * @property string $id_number
 * @property string $remark
 * @property string $applystatus
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Welfareapply extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%treatmentapply}}';
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
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applystatus' => '待遇申请状态',
            'reason' => '审核意见',
            'user_name' => '申请人姓名',
            'id_number' => '身份证号',
            'remark' => '申请诉求',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function getApplyFiles($applyid, $treatid)
    {
        $arrRes = array(
            'require' => array(),
            'optional' => array(),
        );
        $template = Welfaretemplate::find()->where(['treatid' => $treatid])->asArray()->all();
        $applyfiles = Welfareapplyfiles::find()->where(['treatapplyid' => $applyid])->asArray()->all();
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
        if (empty($arrRes['optional'])) {
            $arrRes['optional'] = array();
        }
        if (empty($arrRes['require'])) {
            $arrRes['require'] = array();
        }
        return $arrRes;
    }
}