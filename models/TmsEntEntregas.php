<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tms_ent_entregas".
 *
 * @property string $id_entrega
 * @property integer $id_orden_compra
 * @property integer $id_dia_entrega
 * @property integer $id_status_entrega
 * @property integer $fch_entrega
 */
class TmsEntEntregas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tms_ent_entregas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_orden_compra', 'id_dia_entrega', 'id_status_entrega'], 'required'],
            [['id_orden_compra', 'id_dia_entrega', 'id_status_entrega', 'fch_entrega'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_entrega' => 'Id Entrega',
            'id_orden_compra' => 'Id Orden Compra',
            'id_dia_entrega' => 'Id Dia Entrega',
            'id_status_entrega' => 'Id Status Entrega',
            'fch_entrega' => 'Fch Entrega',
        ];
    }
}
