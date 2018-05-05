<?php

namespace b\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use b\models\Welfare;
use b\models\Depart;

/**
 *
 */
class WelfareSearch extends Welfare
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     *
     * @return ActiveDataProvider
     */
    public function search($params, $departid=null, $isroot=null)
    {
        if ($departid && $isroot == \Yii::$app->params['adminuser.rootlevelstatus']['subroot']) {
            $depart = Depart::find()->where(['id' => $departid])->one();
            $query = Welfare::find()->where(['department' => $depart->subdepart]);
        } else if ($isroot == \Yii::$app->params['adminuser.rootlevelstatus']['root']) {
            $query = Welfare::find();
        } else {
            $query = Welfare::find()->where(['id' => -1]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

//        $query->andFilterWhere(['like', 'title', $this->title])
//            ->andFilterWhere(['like', 'content', $this->content]);

        /* 排序 */
        $query->orderBy([
            'id' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
