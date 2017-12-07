<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_condiciones_plan".
 *
 * @property string $id_condicion_plan
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntCitas[] $entCitas
 * @property RelCondicionPlanTarifario[] $relCondicionPlanTarifarios
 * @property CatTiposPlanesTarifarios[] $idPlanTarifarios
 */
class CatCondicionesPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_condiciones_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre'], 'required'],
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
            'id_condicion_plan' => 'Id Condicion Plan',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_condicion_plan' => 'id_condicion_plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelCondicionPlanTarifarios()
    {
        return $this->hasMany(RelCondicionPlanTarifario::className(), ['id_condicion_plan' => 'id_condicion_plan'])
        ->joinWith('idPlanTarifario')
            ->orderBy('cat_tipos_planes_tarifarios.txt_nombre ASC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlanTarifarios()
    {
        return $this->hasMany(CatTiposPlanesTarifarios::className(), ['id_tipo_plan' => 'id_plan_tarifario'])->viaTable('rel_condicion_plan_tarifario', ['id_condicion_plan' => 'id_condicion_plan']);
    }
}
