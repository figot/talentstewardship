<?php

namespace b\models\search;

use b\models\Welfareapply;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use b\models\Welfare;

/**
 *
 */
class WelfareapplySearch extends Welfareapply
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id', 'applystatus'], 'integer'],
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
        $query = Welfareapply::find()->where(['treatid' => $params['id']]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'applystatus' => $this->applystatus,
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
