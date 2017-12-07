<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_respuestas".
 *
 * @property string $id_respuesta
 * @property string $id_cuestionario
 * @property string $fch_creacion
 *
 * @property EntCuestionario $idCuestionario
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
            [['id_cuestionario'], 'required'],
            [['id_cuestionario'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['id_cuestionario'], 'exist', 'skipOnError' => true, 'targetClass' => EntCuestionario::className(), 'targetAttribute' => ['id_cuestionario' => 'id_cuestionario']],
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
    public function getRelUsuarioRespuestas()
    {
        return $this->hasMany(RelUsuarioRespuesta::className(), ['id_respuesta' => 'id_respuesta']);
    }
}
