<?php

namespace b\models\search;

use b\models\Hotelmanage;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use b\models\Hotel;

/**
 *
 */
class HotelSearch extends Hotel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'hotelname', 'area'], 'trim'],
            [[ 'hotelname', 'area'], 'string'],
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
        $hotemanage = Hotelmanage::find()->where(['user_id' => \Yii::$app->user->identity->id])->asArray()->one();
        if ($hotemanage['isroot'] == 1) {
            $query = Hotel::find();
        } else if($hotemanage['isroot'] == 3) {
            if (!empty($hotemanage['hotelarea'])) {
                $areas = explode(',', $hotemanage['hotelarea']);
            }
            if (isset($areas)) {
                $query = Hotel::find()->where(['in', 'area', $areas]);
            }
        } else {
            $query = Hotel::find()->where(['id' => $hotemanage['hotelid']]);
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

        $query->andFilterWhere(['like', 'hotelname', $this->hotelname])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'star', $this->star]);

        /* 排序 */
        $query->orderBy([
            'star' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
