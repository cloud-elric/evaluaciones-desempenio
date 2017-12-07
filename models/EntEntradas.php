<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_entradas".
 *
 * @property string $id_entrada
 * @property string $id_equipo
 * @property string $num_unidades
 *
 * @property CatEquipos $idEquipo
 */
class EntEntradas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_entradas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_equipo', 'num_unidades'], 'required'],
            [['id_equipo', 'num_unidades'], 'integer'],
            [['id_equipo'], 'exist', 'skipOnError' => true, 'targetClass' => CatEquipos::className(), 'targetAttribute' => ['id_equipo' => 'id_equipo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_entrada' => 'Id Entrada',
            'id_equipo' => 'Id Equipo',
            'num_unidades' => 'Num Unidades',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEquipo()
    {
        return $this->hasOne(CatEquipos::className(), ['id_equipo' => 'id_equipo']);
    }
}
