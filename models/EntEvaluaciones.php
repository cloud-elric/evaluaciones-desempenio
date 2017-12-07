<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_evaluaciones".
 *
 * @property string $id_evaluacion
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $fch_inicio
 * @property string $fch_fin
 * @property integer $b_habilitado
 *
 * @property EntCuestionario[] $entCuestionarios
 */
class EntEvaluaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_evaluaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_descripcion'], 'required'],
            [['fch_inicio', 'fch_fin'], 'safe'],
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
            'id_evaluacion' => 'Id Evaluacion',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'fch_inicio' => 'Fch Inicio',
            'fch_fin' => 'Fch Fin',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCuestionarios()
    {
        return $this->hasMany(EntCuestionario::className(), ['id_evaluacion' => 'id_evaluacion']);
    }
}
