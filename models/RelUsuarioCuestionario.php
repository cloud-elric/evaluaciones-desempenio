<?php

namespace app\models;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;

/**
 * This is the model class for table "rel_usuario_cuestionario".
 *
 * @property string $id_usuario_cuestionario
 * @property string $id_usuario
 * @property string $id_usuario_calificado
 * @property string $id_evaluacion
 * @property string $b_completado
 * @property string $fch_creacion
 *
 * @property EntUsuarios $idUsuario
 * @property EntEvaluaciones $idEvaluacion
 * @property EntUsuarios $idUsuarioCalificado
 */
class RelUsuarioCuestionario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_usuario_cuestionario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_usuario_calificado', 'id_evaluacion'], 'required'],
            [['id_usuario', 'id_usuario_calificado', 'id_evaluacion', 'b_completado'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
            [['id_evaluacion'], 'exist', 'skipOnError' => true, 'targetClass' => EntEvaluaciones::className(), 'targetAttribute' => ['id_evaluacion' => 'id_evaluacion']],
            [['id_usuario_calificado'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario_calificado' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario_cuestionario' => 'Id Usuario Cuestionario',
            'id_usuario' => 'Id Usuario',
            'id_usuario_calificado' => 'Id Usuario Calificado',
            'id_evaluacion' => 'Id Evaluacion',
            'b_completado' => 'B Completado',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(EntUsuarios::className(), ['id_usuario' => 'id_usuario']);
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
    public function getIdUsuarioCalificado()
    {
        return $this->hasOne(EntUsuarios::className(), ['id_usuario' => 'id_usuario_calificado']);
    }
}
