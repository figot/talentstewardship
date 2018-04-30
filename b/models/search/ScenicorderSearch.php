<?php

namespace b\models\search;

use b\models\Scenicorder;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 *
 */
class ScenicorderSearch extends Scenicorder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

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
        $query = Scenicorder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'scenicid' => $params['scenicid'],
        ]);

        /* 排序 */
        $query->orderBy([
            'id' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
