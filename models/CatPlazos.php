<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_plazos".
 *
 * @property string $id_plazo
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntCitas[] $entCitas
 * @property RelPlanPlazo[] $relPlanPlazos
 * @property CatTiposPlanesTarifarios[] $idPlanTarifarios
 */
class CatPlazos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_plazos';
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
            'id_plazo' => 'Id Plazo',
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
        return $this->hasMany(EntCitas::className(), ['id_plazo' => 'id_plazo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelPlanPlazos()
    {
        return $this->hasMany(RelPlanPlazo::className(), ['id_plazo' => 'id_plazo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlanTarifarios()
    {
        return $this->hasMany(CatTiposPlanesTarifarios::className(), ['id_tipo_plan' => 'id_plan_tarifario'])->viaTable('rel_plan_plazo', ['id_plazo' => 'id_plazo']);
    }
}
