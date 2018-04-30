<?php

namespace b\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use b\models\Devplat;

/**
 *
 */
class DevplatSearch extends Devplat
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
        $query = Devplat::find();

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

        $query->andFilterWhere(['like', 'platname', $this->platname]);

        /* 排序 */
        $query->orderBy([
            'id' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
