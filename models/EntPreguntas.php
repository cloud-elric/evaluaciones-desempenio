<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_preguntas".
 *
 * @property string $id_pregunta
 * @property string $id_cuestionario
 * @property string $id_tipo_pregunta
 * @property string $txt_pregunta
 * @property integer $b_habilitado
 *
 * @property CatTipoPregunta $idTipoPregunta
 * @property EntCuestionario $idCuestionario
 * @property RelUsuarioRespuesta[] $relUsuarioRespuestas
 */
class EntPreguntas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_preguntas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cuestionario', 'id_tipo_pregunta', 'txt_pregunta'], 'required'],
            [['id_cuestionario', 'id_tipo_pregunta', 'b_habilitado'], 'integer'],
            [['txt_pregunta'], 'string'],
            [['id_tipo_pregunta'], 'exist', 'skipOnError' => true, 'targetClass' => CatTipoPregunta::className(), 'targetAttribute' => ['id_tipo_pregunta' => 'id_tipo_pregunta']],
            [['id_cuestionario'], 'exist', 'skipOnError' => true, 'targetClass' => EntCuestionario::className(), 'targetAttribute' => ['id_cuestionario' => 'id_cuestionario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pregunta' => 'Id Pregunta',
            'id_cuestionario' => 'Id Cuestionario',
            'id_tipo_pregunta' => 'Id Tipo Pregunta',
            'txt_pregunta' => 'Txt Pregunta',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoPregunta()
    {
        return $this->hasOne(CatTipoPregunta::className(), ['id_tipo_pregunta' => 'id_tipo_pregunta']);
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
        return $this->hasMany(RelUsuarioRespuesta::className(), ['id_pregunta' => 'id_pregunta']);
    }
}
