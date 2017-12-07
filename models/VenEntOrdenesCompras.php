<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ven_ent_ordenes_compras".
 *
 * @property string $id_orden_compra
 * @property string $id_cliente
 * @property string $id_status_orden_compra
 * @property string $fch_creacion
 *
 * @property VenCatStatusOrdenesCompras $idStatusOrdenCompra
 * @property VenEntClientes $idCliente
 * @property VenEntProductosOrdenCompra[] $venEntProductosOrdenCompras
 */
class VenEntOrdenesCompras extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ven_ent_ordenes_compras';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliente', 'id_status_orden_compra'], 'required'],
            [['id_cliente', 'id_status_orden_compra'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['id_status_orden_compra'], 'exist', 'skipOnError' => true, 'targetClass' => VenCatStatusOrdenesCompras::className(), 'targetAttribute' => ['id_status_orden_compra' => 'id_status_orden_compra']],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => VenEntClientes::className(), 'targetAttribute' => ['id_cliente' => 'id_cliente']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_orden_compra' => 'Id Orden Compra',
            'id_cliente' => 'Id Cliente',
            'id_status_orden_compra' => 'Id Status Orden Compra',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatusOrdenCompra()
    {
        return $this->hasOne(VenCatStatusOrdenesCompras::className(), ['id_status_orden_compra' => 'id_status_orden_compra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCliente()
    {
        return $this->hasOne(VenEntClientes::className(), ['id_cliente' => 'id_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenEntProductosOrdenCompras()
    {
        return $this->hasMany(VenEntProductosOrdenCompra::className(), ['id_orden_compra' => 'id_orden_compra']);
    }
}
