<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_equipos".
 *
 * @property string $id_equipo
 * @property string $txt_token
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $txt_clave_sap
 * @property string $b_habilitado
 *
 * @property EntCitas[] $entCitas
 * @property RelEquipoPlazoCosto[] $relEquipoPlazoCostos
 */
class CatEquipos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_equipos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_token', 'txt_nombre', 'txt_clave_sap'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_token'], 'string', 'max' => 60],
            [['txt_nombre'], 'string', 'max' => 150],
            [['txt_descripcion'], 'string', 'max' => 500],
            [['txt_clave_sap'], 'string', 'max' => 100],
            [['txt_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_equipo' => 'Id Equipo',
            'txt_token' => 'Txt Token',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'txt_clave_sap' => 'Txt Clave Sap',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_equipo' => 'id_equipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelEquipoPlazoCostos()
    {
        return $this->hasMany(RelEquipoPlazoCosto::className(), ['id_equipo' => 'id_equipo']);
    }
}
