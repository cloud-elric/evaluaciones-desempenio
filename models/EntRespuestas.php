<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_respuestas".
 *
 * @property string $id_respuesta
 * @property string $id_cuestionario
 * @property string $id_area
 * @property string $id_nivel
 * @property string $id_usuario
 * @property string $id_usuario_evaluado
 * @property string $fch_creacion
 *
 * @property CatAreas $idArea
 * @property CatNiveles $idNivel
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
            [['id_cuestionario', 'id_area', 'id_usuario', 'id_usuario_evaluado'], 'required'],
            [['id_cuestionario', 'id_area', 'id_nivel', 'id_usuario', 'id_usuario_evaluado'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => CatAreas::className(), 'targetAttribute' => ['id_area' => 'id_area']],
            [['id_nivel'], 'exist', 'skipOnError' => true, 'targetClass' => CatNiveles::className(), 'targetAttribute' => ['id_nivel' => 'id_nivel']],
            [['id_cuestionario'], 'exist', 'skipOnError' => true, 'targetClass' => EntCuestionario::className(), 'targetAttribute' => ['id_cuestionario' => 'id_cuestionario']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => ModUsuariosEntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
            [['id_usuario_evaluado'], 'exist', 'skipOnError' => true, 'targetClass' => ModUsuariosEntUsuarios::className(), 'targetAttribute' => ['id_usuario_evaluado' => 'id_usuario']],
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
            'id_area' => 'Id Area',
            'id_nivel' => 'Id Nivel',
            'id_usuario' => 'Id Usuario',
            'id_usuario_evaluado' => 'Id Usuario Evaluado',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(CatAreas::className(), ['id_area' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNivel()
    {
        return $this->hasOne(CatNiveles::className(), ['id_nivel' => 'id_nivel']);
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
        return $this->hasOne(ModUsuariosEntUsuarios::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuarioEvaluado()
    {
        return $this->hasOne(ModUsuariosEntUsuarios::className(), ['id_usuario' => 'id_usuario_evaluado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelUsuarioRespuestas()
    {
        return $this->hasMany(RelUsuarioRespuesta::className(), ['id_respuesta' => 'id_respuesta']);
    }
}
