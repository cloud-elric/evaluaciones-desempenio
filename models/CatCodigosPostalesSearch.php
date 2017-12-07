<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatCodigosPostales;

/**
 * CatCodigosPostalesSearch represents the model behind the search form about `app\models\CatCodigosPostales`.
 */
class CatCodigosPostalesSearch extends CatCodigosPostales
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_codigo_postal'], 'safe'],
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
    public function search($params, $page=0)
    {
        $query = CatCodigosPostales::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
                'page' => $page
            ],
            'sort' => [
                'defaultOrder' => [
                    'txt_codigo_postal' => \SORT_ASC,
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
        $query->andFilterWhere(['like', 'txt_codigo_postal', $this->txt_codigo_postal.'%', false]);

        return $dataProvider;
    }
}
