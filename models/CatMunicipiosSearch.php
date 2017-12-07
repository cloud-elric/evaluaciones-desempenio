<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatMunicipios;

/**
 * CatMunicipiosSearch represents the model behind the search form about `app\models\CatMunicipios`.
 */
class CatMunicipiosSearch extends CatMunicipios
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_municipio', 'id_estado', 'id_area'], 'integer'],
            [['txt_nombre', 'txt_descripcion'], 'safe'],
            [['num_latitud', 'num_longitud'], 'number'],
            [['b_habilitado'], 'boolean'],
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
        $query = CatMunicipios::find();

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
            'id_municipio' => $this->id_municipio,
            'id_estado' => $this->id_estado,
            'id_area' => $this->id_area,
            'num_latitud' => $this->num_latitud,
            'num_longitud' => $this->num_longitud,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_descripcion', $this->txt_descripcion]);

        return $dataProvider;
    }
}
