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
    public function search($params, $departid=null)
    {
        $departname = null;
        if ($departid) {
            $depart = Depart::find()->where(['id' => $departid])->one();
            $departname = $depart->subdepart;
        }
        if ($departname) {
            $query = Welfare::find()->where(['department' => $departname]);
        } else {
            $query = Welfare::find();
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
