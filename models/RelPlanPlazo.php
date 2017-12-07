<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_plan_plazo".
 *
 * @property string $id_plan_tarifario
 * @property string $id_plazo
 *
 * @property CatPlazos $idPlazo
 * @property CatTiposPlanesTarifarios $idPlanTarifario
 */
class RelPlanPlazo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_plan_plazo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_plan_tarifario', 'id_plazo'], 'required'],
            [['id_plan_tarifario', 'id_plazo'], 'integer'],
            [['id_plazo'], 'exist', 'skipOnError' => true, 'targetClass' => CatPlazos::className(), 'targetAttribute' => ['id_plazo' => 'id_plazo']],
            [['id_plan_tarifario'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposPlanesTarifarios::className(), 'targetAttribute' => ['id_plan_tarifario' => 'id_tipo_plan']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_plan_tarifario' => 'Id Plan Tarifario',
            'id_plazo' => 'Id Plazo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlazo()
    {
        return $this->hasOne(CatPlazos::className(), ['id_plazo' => 'id_plazo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlanTarifario()
    {
        return $this->hasOne(CatTiposPlanesTarifarios::className(), ['id_tipo_plan' => 'id_plan_tarifario']);
    }
}
