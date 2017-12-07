<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ven_ent_clientes".
 *
 * @property string $id_cliente
 * @property string $id_tipo_cliente
 * @property string $txt_nombre
 * @property string $txt_razon_social
 * @property string $txt_rfc
 * @property string $fch_creacion
 * @property string $b_habilitado
 *
 * @property VenEntClientes $idTipoCliente
 * @property VenEntClientes[] $venEntClientes
 * @property VenEntContactoClientes[] $venEntContactoClientes
 * @property VenEntOrdenesCompras[] $venEntOrdenesCompras
 */
class VenEntClientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ven_ent_clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_cliente', 'txt_nombre', 'txt_razon_social'], 'required'],
            [['id_tipo_cliente', 'b_habilitado'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['txt_nombre', 'txt_razon_social'], 'string', 'max' => 100],
            [['txt_rfc'], 'string', 'max' => 13],
            [['id_tipo_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => VenEntClientes::className(), 'targetAttribute' => ['id_tipo_cliente' => 'id_cliente']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cliente' => 'Id Cliente',
            'id_tipo_cliente' => 'Id Tipo Cliente',
            'txt_nombre' => 'Txt Nombre',
            'txt_razon_social' => 'Txt Razon Social',
            'txt_rfc' => 'Txt Rfc',
            'fch_creacion' => 'Fch Creacion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoCliente()
    {
        return $this->hasOne(VenEntClientes::className(), ['id_cliente' => 'id_tipo_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenEntClientes()
    {
        return $this->hasMany(VenEntClientes::className(), ['id_tipo_cliente' => 'id_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenEntContactoClientes()
    {
        return $this->hasMany(VenEntContactoClientes::className(), ['id_cliente' => 'id_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenEntOrdenesCompras()
    {
        return $this->hasMany(VenEntOrdenesCompras::className(), ['id_cliente' => 'id_cliente']);
    }
}
