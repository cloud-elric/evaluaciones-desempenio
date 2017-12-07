<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ven_ent_contacto_clientes".
 *
 * @property string $id_contacto_cliente
 * @property string $id_cliente
 * @property string $txt_nombre
 * @property string $txt_apellido_paterno
 * @property string $txt_apellido_materno
 * @property string $txt_numero_celular
 * @property string $txt_numero_oficina
 * @property string $txt_extension
 * @property string $txt_numero_extra
 * @property string $txt_email
 * @property string $fch_creacion
 * @property string $fch_nacimiento
 *
 * @property VenEntClientes $idCliente
 */
class VenEntContactoClientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ven_ent_contacto_clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliente', 'txt_nombre', 'txt_apellido_paterno'], 'required'],
            [['id_cliente'], 'integer'],
            [['fch_creacion', 'fch_nacimiento'], 'safe'],
            [['txt_nombre', 'txt_apellido_paterno', 'txt_apellido_materno', 'txt_email'], 'string', 'max' => 100],
            [['txt_numero_celular', 'txt_numero_oficina', 'txt_extension', 'txt_numero_extra'], 'string', 'max' => 10],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => VenEntClientes::className(), 'targetAttribute' => ['id_cliente' => 'id_cliente']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_contacto_cliente' => 'Id Contacto Cliente',
            'id_cliente' => 'Id Cliente',
            'txt_nombre' => 'Txt Nombre',
            'txt_apellido_paterno' => 'Txt Apellido Paterno',
            'txt_apellido_materno' => 'Txt Apellido Materno',
            'txt_numero_celular' => 'Txt Numero Celular',
            'txt_numero_oficina' => 'Txt Numero Oficina',
            'txt_extension' => 'Txt Extension',
            'txt_numero_extra' => 'Txt Numero Extra',
            'txt_email' => 'Txt Email',
            'fch_creacion' => 'Fch Creacion',
            'fch_nacimiento' => 'Fch Nacimiento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCliente()
    {
        return $this->hasOne(VenEntClientes::className(), ['id_cliente' => 'id_cliente']);
    }
}
