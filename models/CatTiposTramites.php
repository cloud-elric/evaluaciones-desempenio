<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_tramites".
 *
 * @property string $id_tramite
 * @property string $txt_token
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntCitas[] $entCitas
 */
class CatTiposTramites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_tramites';
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
            [['txt_nombre'], 'string', 'max' => 100],
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
            'id_tramite' => 'Id Tramite',
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
        return $this->hasMany(EntCitas::className(), ['id_tipo_tramite' => 'id_tramite']);
    }
}
