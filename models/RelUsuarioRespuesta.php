<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_usuario_respuesta".
 *
 * @property string $id_usuario_respuesta
 * @property string $id_respuesta
 * @property string $id_pregunta
 * @property string $txt_valor
 *
 * @property EntPreguntas $idPregunta
 * @property EntRespuestas $idRespuesta
 */
class RelUsuarioRespuesta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_usuario_respuesta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_respuesta', 'id_pregunta', 'txt_valor'], 'required'],
            [['id_respuesta', 'id_pregunta'], 'integer'],
            [['txt_valor'], 'string'],
            [['id_pregunta'], 'exist', 'skipOnError' => true, 'targetClass' => EntPreguntas::className(), 'targetAttribute' => ['id_pregunta' => 'id_pregunta']],
            [['id_respuesta'], 'exist', 'skipOnError' => true, 'targetClass' => EntRespuestas::className(), 'targetAttribute' => ['id_respuesta' => 'id_respuesta']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario_respuesta' => 'Id Usuario Respuesta',
            'id_respuesta' => 'Id Respuesta',
            'id_pregunta' => 'Id Pregunta',
            'txt_valor' => 'Txt Valor',
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
    public function getIdRespuesta()
    {
        return $this->hasOne(EntRespuestas::className(), ['id_respuesta' => 'id_respuesta']);
    }
}
