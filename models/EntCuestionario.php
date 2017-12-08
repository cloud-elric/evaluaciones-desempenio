<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_cuestionario".
 *
 * @property string $id_cuestionario
 * @property string $id_evaluacion
 * @property string $txt_nombre
 * @property string $fch_creacion
 *
 * @property EntEvaluaciones $idEvaluacion
 * @property EntPreguntas[] $entPreguntas
 * @property RelUsuarioCuestionario[] $relUsuarioCuestionarios
 */
class EntCuestionario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_cuestionario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_evaluacion', 'txt_nombre'], 'required'],
            [['id_evaluacion'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['txt_nombre'], 'string', 'max' => 100],
            [['id_evaluacion'], 'exist', 'skipOnError' => true, 'targetClass' => EntEvaluaciones::className(), 'targetAttribute' => ['id_evaluacion' => 'id_evaluacion']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cuestionario' => 'Id Cuestionario',
            'id_evaluacion' => 'Id Evaluacion',
            'txt_nombre' => 'Txt Nombre',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEvaluacion()
    {
        return $this->hasOne(EntEvaluaciones::className(), ['id_evaluacion' => 'id_evaluacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntPreguntas()
    {
        return $this->hasMany(EntPreguntas::className(), ['id_cuestionario' => 'id_cuestionario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelUsuarioCuestionarios()
    {
        return $this->hasMany(RelUsuarioCuestionario::className(), ['id_cuestionario' => 'id_cuestionario']);
    }
}
