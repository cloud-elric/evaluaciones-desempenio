<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_depositos_garantia".
 *
 * @property string $id_tipo_deposito_garantia
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 */
class CatTiposDepositosGarantia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_depositos_garantia';
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
            'id_tipo_deposito_garantia' => 'Id Tipo Deposito Garantia',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }
}
