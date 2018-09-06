<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BukuTamu;

/**
 * BukuTamuSearch represents the model behind the search form about `app\models\BukuTamu`.
 */
class BukuTamuSearch extends BukuTamu
{
    public $santri;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['santri'], 'safe'],
            [['id', 'santri_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BukuTamu::find();
        $query->joinWith(['santri']);
     
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $dataProvider->sort->attributes['santri'] = [
            'asc' => ['santri.nama' => SORT_ASC],
            'desc' => ['santri.nama' => SORT_DESC],
        ];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            //... other searched attributes here
        ])
        ->andFilterWhere(['like', 'santri.nama', $this->santri]);
     
        return $dataProvider;
    }
}
