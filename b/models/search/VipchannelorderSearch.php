<?php

namespace b\models\search;

use b\models\Vipchannelorder;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 *
 */
class VipchannelorderSearch extends Vipchannelorder
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
        $query = Vipchannelorder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'vipchannelid' => $params['vipchannelid'],
        ]);

        /* 排序 */
        $query->orderBy([
            'id' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
