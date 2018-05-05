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
    public function search($params, $departid=null, $isroot=null)
    {
        if ($departid && $isroot == \Yii::$app->params['adminuser.rootlevelstatus']['subroot']) {
            $depart = Depart::find()->where(['id' => $departid])->one();
            $query = Needs::find()->where(['subdepart' => $depart->subdepart]);
        } else if ($isroot == \Yii::$app->params['adminuser.rootlevelstatus']['root']) {
            $query = Needs::find();
        } else {
            $query = Needs::find()->where(['id' => -1]);
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
