<?php

namespace b\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use b\models\Vipchannel;

/**
 *
 */
class VipchannelSearch extends Vipchannel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name', 'area'], 'trim'],
            [[ 'name', 'area'], 'string'],
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
        $query = Vipchannel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'area', $this->area]);

        /* 排序 */
        $query->orderBy([
            'id' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
