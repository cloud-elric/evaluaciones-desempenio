<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tms_cat_status_entrega".
 *
 * @property string $id_status_entrega
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 */
class TmsCatStatusEntrega extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tms_cat_status_entrega';
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
            'id_status_entrega' => 'Id Status Entrega',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }
}
