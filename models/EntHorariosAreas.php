<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_horarios_areas".
 *
 * @property string $id_area
 * @property string $id_horario
 * @property string $id_dia
 * @property string $num_disponibles
 *
 * @property CatAreas $idArea
 * @property CatDias $idDia
 * @property CatHorarios $idHorario
 */
class EntHorariosAreas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_horarios_areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_area', 'id_horario', 'id_dia'], 'required'],
            [['id_area', 'id_horario', 'id_dia', 'num_disponibles'], 'integer'],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => CatAreas::className(), 'targetAttribute' => ['id_area' => 'id_area']],
            [['id_dia'], 'exist', 'skipOnError' => true, 'targetClass' => CatDias::className(), 'targetAttribute' => ['id_dia' => 'id_dia']],
            [['id_horario'], 'exist', 'skipOnError' => true, 'targetClass' => CatHorarios::className(), 'targetAttribute' => ['id_horario' => 'id_horario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_area' => 'Id Area',
            'id_horario' => 'Id Horario',
            'id_dia' => 'Id Dia',
            'num_disponibles' => 'Num Disponibles',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(CatAreas::className(), ['id_area' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDia()
    {
        return $this->hasOne(CatDias::className(), ['id_dia' => 'id_dia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdHorario()
    {
        return $this->hasOne(CatHorarios::className(), ['id_horario' => 'id_horario']);
    }
}
