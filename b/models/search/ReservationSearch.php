<?php

namespace b\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use b\models\Reservation;

/**
 *
 */
class ReservationSearch extends Reservation
{
    public $hotelname;
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
        $query = Reservation::find();
        $query->joinWith(['hotel']);
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

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'status', $this->status]);

        $query->andFilterWhere(['like', 'hotel.hotel_name', $this->hotelname]);

        /* 排序 */
        $query->orderBy([
            'star' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
