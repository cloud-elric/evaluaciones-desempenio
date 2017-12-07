<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatEquipos;

/**
 * EntEquiposSearch represents the model behind the search form about `app\models\CatEquipos`.
 */
class EntEquiposSearch extends CatEquipos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_equipo', 'b_habilitado'], 'integer'],
            [['txt_token', 'txt_nombre', 'txt_descripcion', 'txt_clave_sap'], 'safe'],
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
        $query = CatEquipos::find();

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
            'id_equipo' => $this->id_equipo,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'txt_token', $this->txt_token])
            ->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_descripcion', $this->txt_descripcion])
            ->andFilterWhere(['like', 'txt_clave_sap', $this->txt_clave_sap]);

        return $dataProvider;
    }

    public function searchEquipo($params, $page=0){
        $query = CatEquipos::find();

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
            'id_equipo' => $this->id_equipo,
            'b_habilitado' => 1,
        ]);

        $query->andFilterWhere(['like', 'txt_token', $this->txt_token])
            ->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_descripcion', $this->txt_descripcion])
            ->andFilterWhere(['like', 'txt_clave_sap', $this->txt_clave_sap]);

        return $dataProvider;
    }
}
