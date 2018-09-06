<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaksi;

/**
 * TransaksiSearch represents the model behind the search form about `app\models\Transaksi`.
 */
class TransaksiSearch extends Transaksi
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'buku_id', 'santri_id'], 'integer'],
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
        $query = Transaksi::find();
        $query->joinWith(['buku', 'santri']);
     
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
     
        $dataProvider->sort->attributes['buku_judul'] = [
            'asc' => ['buku.judul' => SORT_ASC],
            'desc' => ['buku.judul' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['buku_pengarang'] = [
            'asc' => ['buku.pengarang' => SORT_ASC],
            'desc' => ['buku.pengarang' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['santri_nama'] = [
            'asc' => ['santri.nama' => SORT_ASC],
            'desc' => ['santri.nama' => SORT_DESC],
        ];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            //... other searched attributes here
        ])
        ->andFilterWhere(['like', 'buku.judul', $this->buku_judul])
        ->andFilterWhere(['like', 'buku.pengarang', $this->buku_pengarang])
        ->andFilterWhere(['like', 'santri.nama', $this->santri_nama])
        ->andFilterWhere(['like', 'santri.id', $this->santri_id]);
     
        return $dataProvider;
    }

}
