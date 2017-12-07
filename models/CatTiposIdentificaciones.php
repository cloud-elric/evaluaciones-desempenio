<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_identificaciones".
 *
 * @property string $id_tipo_identificacion
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 */
class CatTiposIdentificaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_identificaciones';
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
            [['txt_descripcion'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_identificacion' => 'Id Tipo Identificacion',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }
}
