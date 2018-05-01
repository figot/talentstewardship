<?php

namespace b\models\search;

use b\models\Depart;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use b\models\Project;

/**
 *
 */
class ProjectSearch extends Project
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id', 'ptype', 'status'], 'integer'],
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
            $query = Project::find()->where(['department' => $departname]);
        } else {
            $query = Project::find();
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
            'ptype' => $this->ptype,
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
