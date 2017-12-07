<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EntHorariosAreas;

/**
 * EntHorariosAreasSearch represents the model behind the search form about `app\models\EntHorariosAreas`.
 */
class EntHorariosAreasSearch extends EntHorariosAreas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_horario_area', 'id_area'], 'integer'],
            [['txt_hora_inicial', 'txt_hora_final'], 'safe'],
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
        $query = EntHorariosAreas::find();

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
            'id_horario_area' => $this->id_horario_area,
            'id_area' => $this->id_area,
        ]);

        $query->andFilterWhere(['like', 'txt_hora_inicial', $this->txt_hora_inicial])
            ->andFilterWhere(['like', 'txt_hora_final', $this->txt_hora_final]);

        return $dataProvider;
    }
}
