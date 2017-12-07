<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatSimsCards;

/**
 * CatSimsSearch represents the model behind the search form about `app\models\CatSimsCards`.
 */
class CatSimsSearch extends CatSimsCards
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sim_card', 'b_habilitado'], 'integer'],
            [['txt_token', 'txt_nombre', 'txt_clave_sim_card', 'txt_descripcion'], 'safe'],
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
        $query = CatSimsCards::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_sim_card' => $this->id_sim_card,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'txt_token', $this->txt_token])
            ->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_clave_sim_card', $this->txt_clave_sim_card])
            ->andFilterWhere(['like', 'txt_descripcion', $this->txt_descripcion]);

        return $dataProvider;
    }

    public function searchSim($params, $page)
    {
        $query = CatSimsCards::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
                'page' => $page
            ],
            'sort' => [
                'defaultOrder' => [
                    'txt_nombre' => SORT_DESC,
                ]
            ],
        ]);
        $this->attributes =$params;

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_sim_card' => $this->id_sim_card,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'txt_token', $this->txt_token])
            ->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_clave_sim_card', $this->txt_clave_sim_card])
            ->andFilterWhere(['like', 'txt_descripcion', $this->txt_descripcion]);

        return $dataProvider;
    }

    
}
