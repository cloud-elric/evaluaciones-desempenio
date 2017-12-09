<?php

namespace app\models;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;

/**
 * This is the model class for table "ent_respuestas".
 *
 * @property string $id_respuesta
 * @property string $id_cuestionario
 * @property string $id_usuario
 * @property string $id_usuario_evaluado
 * @property string $fch_creacion
 *
 * @property EntCuestionario $idCuestionario
 * @property ModUsuariosEntUsuarios $idUsuario
 * @property ModUsuariosEntUsuarios $idUsuarioEvaluado
 * @property RelUsuarioRespuesta[] $relUsuarioRespuestas
 */
class EntRespuestas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_respuestas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cuestionario', 'id_usuario', 'id_usuario_evaluado'], 'required'],
            [['id_cuestionario', 'id_usuario', 'id_usuario_evaluado'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['id_cuestionario'], 'exist', 'skipOnError' => true, 'targetClass' => EntCuestionario::className(), 'targetAttribute' => ['id_cuestionario' => 'id_cuestionario']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
            [['id_usuario_evaluado'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario_evaluado' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_respuesta' => 'Id Respuesta',
            'id_cuestionario' => 'Id Cuestionario',
            'id_usuario' => 'Id Usuario',
            'id_usuario_evaluado' => 'Id Usuario Evaluado',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCuestionario()
    {
        return $this->hasOne(EntCuestionario::className(), ['id_cuestionario' => 'id_cuestionario']);
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
    public function getIdUsuarioEvaluado()
    {
        return $this->hasOne(EntUsuarios::className(), ['id_usuario' => 'id_usuario_evaluado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelUsuarioRespuestas()
    {
        return $this->hasMany(RelUsuarioRespuesta::className(), ['id_respuesta' => 'id_respuesta']);
    }
}
