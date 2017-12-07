<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatTiposPlanesTarifarios;

/**
 * CatTiposPlanesTarifariosSearch represents the model behind the search form about `app\models\CatTiposPlanesTarifarios`.
 */
class CatTiposPlanesTarifariosSearch extends CatTiposPlanesTarifarios
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_plan', 'b_habilitado'], 'integer'],
            [['txt_nombre', 'txt_descripcion'], 'safe'],
            [['num_costo_renta'], 'number'],
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
        $query = CatTiposPlanesTarifarios::find();

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
            'id_tipo_plan' => $this->id_tipo_plan,
            'num_costo_renta' => $this->num_costo_renta,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_descripcion', $this->txt_descripcion]);

        return $dataProvider;
    }
}
