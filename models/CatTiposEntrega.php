<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_entrega".
 *
 * @property string $id_tipo_entrega
 * @property string $txt_token
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntCitas[] $entCitas
 */
class CatTiposEntrega extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_entrega';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_token', 'txt_nombre'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_token'], 'string', 'max' => 60],
            [['txt_nombre'], 'string', 'max' => 150],
            [['txt_descripcion'], 'string', 'max' => 500],
            [['txt_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_entrega' => 'Id Tipo Entrega',
            'txt_token' => 'Txt Token',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_tipo_entrega' => 'id_tipo_entrega']);
    }
}
