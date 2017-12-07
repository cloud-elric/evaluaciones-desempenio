<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_disponibilidad_envio".
 *
 * @property string $id_disponibilidad_envio
 * @property string $id_horarios_areas
 * @property string $num_disponibles
 *
 * @property EntHorariosAreas $idHorariosAreas
 */
class EntDisponibilidadEnvio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_disponibilidad_envio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_horarios_areas'], 'required'],
            [['id_horarios_areas', 'num_disponibles'], 'integer'],
            [['id_horarios_areas'], 'exist', 'skipOnError' => true, 'targetClass' => EntHorariosAreas::className(), 'targetAttribute' => ['id_horarios_areas' => 'id_horario_area']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_disponibilidad_envio' => 'Id Disponibilidad Envio',
            'id_horarios_areas' => 'Id Horarios Areas',
            'num_disponibles' => 'Num Disponibles',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdHorariosAreas()
    {
        return $this->hasOne(EntHorariosAreas::className(), ['id_horario_area' => 'id_horarios_areas']);
    }
}
