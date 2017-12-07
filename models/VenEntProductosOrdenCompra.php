<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ven_ent_productos_orden_compra".
 *
 * @property string $id_producto_orden_compra
 * @property string $id_orden_compra
 * @property string $id_producto
 * @property string $id_instancia_producto
 * @property string $num_productos
 * @property double $num_precio_unitario
 * @property double $num_subtotal
 * @property double $num_porcentaje_impuesto
 * @property double $num_total
 *
 * @property InvCatInstanciaProducto $idInstanciaProducto
 * @property InvCatProductos $idProducto
 * @property VenEntOrdenesCompras $idOrdenCompra
 */
class VenEntProductosOrdenCompra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ven_ent_productos_orden_compra';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_orden_compra', 'id_producto', 'id_instancia_producto', 'num_productos'], 'integer'],
            [['id_producto', 'id_instancia_producto', 'num_productos', 'num_precio_unitario', 'num_subtotal', 'num_porcentaje_impuesto', 'num_total'], 'required'],
            [['num_precio_unitario', 'num_subtotal', 'num_porcentaje_impuesto', 'num_total'], 'number'],
            [['id_instancia_producto'], 'exist', 'skipOnError' => true, 'targetClass' => InvCatInstanciaProducto::className(), 'targetAttribute' => ['id_instancia_producto' => 'id_instancia_producto']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => InvCatProductos::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
            [['id_orden_compra'], 'exist', 'skipOnError' => true, 'targetClass' => VenEntOrdenesCompras::className(), 'targetAttribute' => ['id_orden_compra' => 'id_orden_compra']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_producto_orden_compra' => 'Id Producto Orden Compra',
            'id_orden_compra' => 'Id Orden Compra',
            'id_producto' => 'Id Producto',
            'id_instancia_producto' => 'Id Instancia Producto',
            'num_productos' => 'Num Productos',
            'num_precio_unitario' => 'Num Precio Unitario',
            'num_subtotal' => 'Num Subtotal',
            'num_porcentaje_impuesto' => 'Num Porcentaje Impuesto',
            'num_total' => 'Num Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInstanciaProducto()
    {
        return $this->hasOne(InvCatInstanciaProducto::className(), ['id_instancia_producto' => 'id_instancia_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(InvCatProductos::className(), ['id_producto' => 'id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOrdenCompra()
    {
        return $this->hasOne(VenEntOrdenesCompras::className(), ['id_orden_compra' => 'id_orden_compra']);
    }
}
