<?php

namespace b\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use b\models\Applier;

/**
 *
 */
class ApplierSearch extends Applier
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
    public function search($params)
    {
        $query = Applier::find();

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

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        /* 排序 */
        $query->orderBy([
            'id' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
