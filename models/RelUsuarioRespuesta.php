<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_usuario_respuesta".
 *
 * @property string $id_usuario_respuesta
 * @property string $id_usuario_cuestionario
 * @property string $id_respuesta
 * @property string $txt_valor
 *
 * @property RelUsuarioCuestionario $idUsuarioCuestionario
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
            [['id_usuario_cuestionario', 'id_respuesta', 'txt_valor'], 'required'],
            [['id_usuario_cuestionario', 'id_respuesta'], 'integer'],
            [['txt_valor'], 'string'],
            [['id_usuario_cuestionario'], 'exist', 'skipOnError' => true, 'targetClass' => RelUsuarioCuestionario::className(), 'targetAttribute' => ['id_usuario_cuestionario' => 'id_usuario_cuestionario']],
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
            'id_usuario_cuestionario' => 'Id Usuario Cuestionario',
            'id_respuesta' => 'Id Respuesta',
            'txt_valor' => 'Txt Valor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuarioCuestionario()
    {
        return $this->hasOne(RelUsuarioCuestionario::className(), ['id_usuario_cuestionario' => 'id_usuario_cuestionario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRespuesta()
    {
        return $this->hasOne(EntRespuestas::className(), ['id_respuesta' => 'id_respuesta']);
    }
}
