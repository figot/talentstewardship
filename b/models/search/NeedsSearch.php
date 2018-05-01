<?php

namespace b\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use b\models\Needs;
use b\models\Depart;

/**
 *
 */
class NeedsSearch extends Needs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id', 'title', 'content', 'applystatus', 'department'], 'integer'],
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
            $query = Needs::find()->where(['department' => $departname]);
        } else {
            $query = Needs::find();
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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subdepart', $this->subdepart])
            ->andFilterWhere(['like', 'department', $this->department]);

        /* 排序 */
        $query->orderBy([
            'id' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
