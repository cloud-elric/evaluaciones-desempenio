<?php

namespace app\models;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;

/**
 * This is the model class for table "ent_historial_cambios_citas".
 *
 * @property string $id_cambio_cita
 * @property string $id_usuario
 * @property string $id_cita
 * @property string $txt_modificacion
 * @property string $fch_modificacion
 *
 * @property EntCitas $idCita
 * @property ModUsuariosEntUsuarios $idUsuario
 */
class EntHistorialCambiosCitas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_historial_cambios_citas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_cita', 'txt_modificacion'], 'required'],
            [['id_usuario', 'id_cita'], 'integer'],
            [['fch_modificacion'], 'safe'],
            [['txt_modificacion'], 'string', 'max' => 150],
            [['id_cita'], 'exist', 'skipOnError' => true, 'targetClass' => EntCitas::className(), 'targetAttribute' => ['id_cita' => 'id_cita']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cambio_cita' => 'Id Cambio Cita',
            'id_usuario' => 'Id Usuario',
            'id_cita' => 'Id Cita',
            'txt_modificacion' => 'Txt Modificacion',
            'fch_modificacion' => 'Fch Modificacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCita()
    {
        return $this->hasOne(EntCitas::className(), ['id_cita' => 'id_cita']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(ModUsuariosEntUsuarios::className(), ['id_usuario' => 'id_usuario']);
    }
}
