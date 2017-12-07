<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_planes_tarifarios".
 *
 * @property string $id_tipo_plan
 * @property string $txt_nombre
 * @property double $num_costo_renta
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntCitas[] $entCitas
 * @property RelCondicionPlanTarifario[] $relCondicionPlanTarifarios
 * @property CatCondicionesPlan[] $idCondicionPlans
 * @property RelPlanPlazo[] $relPlanPlazos
 * @property CatPlazos[] $idPlazos
 */
class CatTiposPlanesTarifarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_planes_tarifarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre'], 'required'],
            [['num_costo_renta'], 'number'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 100],
            [['txt_descripcion'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_plan' => 'Id Tipo Plan',
            'txt_nombre' => 'Txt Nombre',
            'num_costo_renta' => 'Num Costo Renta',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_tipo_plan_tarifario' => 'id_tipo_plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelCondicionPlanTarifarios()
    {
        return $this->hasMany(RelCondicionPlanTarifario::className(), ['id_plan_tarifario' => 'id_tipo_plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCondicionPlans()
    {
        return $this->hasMany(CatCondicionesPlan::className(), ['id_condicion_plan' => 'id_condicion_plan'])->viaTable('rel_condicion_plan_tarifario', ['id_plan_tarifario' => 'id_tipo_plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelPlanPlazos()
    {
        return $this->hasMany(RelPlanPlazo::className(), ['id_plan_tarifario' => 'id_tipo_plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlazos()
    {
        return $this->hasMany(CatPlazos::className(), ['id_plazo' => 'id_plazo'])->viaTable('rel_plan_plazo', ['id_plan_tarifario' => 'id_tipo_plan']);
    }
}
