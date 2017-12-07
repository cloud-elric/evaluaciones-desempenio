<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_respuestas".
 *
 * @property string $id_respuesta
 * @property string $id_pregunta
 * @property string $fch_creacion
 *
 * @property EntPreguntas $idPregunta
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
            [['id_pregunta'], 'required'],
            [['id_pregunta'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['id_pregunta'], 'exist', 'skipOnError' => true, 'targetClass' => EntPreguntas::className(), 'targetAttribute' => ['id_pregunta' => 'id_pregunta']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_respuesta' => 'Id Respuesta',
            'id_pregunta' => 'Id Pregunta',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPregunta()
    {
        return $this->hasOne(EntPreguntas::className(), ['id_pregunta' => 'id_pregunta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelUsuarioRespuestas()
    {
        return $this->hasMany(RelUsuarioRespuesta::className(), ['id_respuesta' => 'id_respuesta']);
    }
}
