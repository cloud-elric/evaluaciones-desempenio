<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ven_cat_status_ordenes_compras".
 *
 * @property string $id_status_orden_compra
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property VenEntOrdenesCompras[] $venEntOrdenesCompras
 */
class VenCatStatusOrdenesCompras extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ven_cat_status_ordenes_compras';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_descripcion'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 50],
            [['txt_descripcion'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_status_orden_compra' => 'Id Status Orden Compra',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenEntOrdenesCompras()
    {
        return $this->hasMany(VenEntOrdenesCompras::className(), ['id_status_orden_compra' => 'id_status_orden_compra']);
    }
}
