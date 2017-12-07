<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_equipo_plazo_costo".
 *
 * @property string $id_equipo
 * @property string $id_tipo_plan_tarifario
 * @property string $id_plazo
 * @property double $num_costo
 *
 * @property CatEquipos $idEquipo
 * @property CatPlazos $idPlazo
 * @property CatTiposPlanesTarifarios $idTipoPlanTarifario
 */
class RelEquipoPlazoCosto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_equipo_plazo_costo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_equipo', 'id_tipo_plan_tarifario', 'id_plazo'], 'required'],
            [['id_equipo', 'id_tipo_plan_tarifario', 'id_plazo'], 'integer'],
            [['num_costo'], 'number'],
            [['id_equipo'], 'exist', 'skipOnError' => true, 'targetClass' => CatEquipos::className(), 'targetAttribute' => ['id_equipo' => 'id_equipo']],
            [['id_plazo'], 'exist', 'skipOnError' => true, 'targetClass' => CatPlazos::className(), 'targetAttribute' => ['id_plazo' => 'id_plazo']],
            [['id_tipo_plan_tarifario'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposPlanesTarifarios::className(), 'targetAttribute' => ['id_tipo_plan_tarifario' => 'id_tipo_plan']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_equipo' => 'Id Equipo',
            'id_tipo_plan_tarifario' => 'Id Tipo Plan Tarifario',
            'id_plazo' => 'Id Plazo',
            'num_costo' => 'Num Costo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEquipo()
    {
        return $this->hasOne(CatEquipos::className(), ['id_equipo' => 'id_equipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlazo()
    {
        return $this->hasOne(CatPlazos::className(), ['id_plazo' => 'id_plazo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoPlanTarifario()
    {
        return $this->hasOne(CatTiposPlanesTarifarios::className(), ['id_tipo_plan' => 'id_tipo_plan_tarifario']);
    }
}
