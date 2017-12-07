<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipo_pregunta".
 *
 * @property string $id_tipo_pregunta
 * @property string $txt_nombre
 * @property string $b_habilitado
 *
 * @property EntPreguntas[] $entPreguntas
 */
class CatTipoPregunta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipo_pregunta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_pregunta' => 'Id Tipo Pregunta',
            'txt_nombre' => 'Txt Nombre',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntPreguntas()
    {
        return $this->hasMany(EntPreguntas::className(), ['id_tipo_pregunta' => 'id_tipo_pregunta']);
    }
}
