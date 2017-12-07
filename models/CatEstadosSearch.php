<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatEstados;

/**
 * CatEstadosSearch represents the model behind the search form about `app\models\CatEstados`.
 */
class CatEstadosSearch extends CatEstados
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estado', 'id_pais', 'id_area', 'num_estado', 'b_habilitado'], 'integer'],
            [['txt_nombre', 'txt_descripcion'], 'safe'],
            [['num_latitud', 'num_longitud'], 'number'],
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
        $query = CatEstados::find();

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
            'id_estado' => $this->id_estado,
            'id_pais' => $this->id_pais,
            'id_area' => $this->id_area,
            'num_estado' => $this->num_estado,
            'num_latitud' => $this->num_latitud,
            'num_longitud' => $this->num_longitud,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_descripcion', $this->txt_descripcion]);

        return $dataProvider;
    }

    public function searchEstados($params, $page=0){
        $query = CatEstados::find()->where(['b_habilitado'=>1]);

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
            'id_estado' => $this->id_estado,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre]);

        return $dataProvider;
    }
}
