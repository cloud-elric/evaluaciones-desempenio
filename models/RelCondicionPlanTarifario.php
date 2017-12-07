<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_condicion_plan_tarifario".
 *
 * @property string $id_condicion_plan
 * @property string $id_plan_tarifario
 *
 * @property CatCondicionesPlan $idCondicionPlan
 * @property CatTiposPlanesTarifarios $idPlanTarifario
 */
class RelCondicionPlanTarifario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_condicion_plan_tarifario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_condicion_plan', 'id_plan_tarifario'], 'required'],
            [['id_condicion_plan', 'id_plan_tarifario'], 'integer'],
            [['id_condicion_plan'], 'exist', 'skipOnError' => true, 'targetClass' => CatCondicionesPlan::className(), 'targetAttribute' => ['id_condicion_plan' => 'id_condicion_plan']],
            [['id_plan_tarifario'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposPlanesTarifarios::className(), 'targetAttribute' => ['id_plan_tarifario' => 'id_tipo_plan']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_condicion_plan' => 'Id Condicion Plan',
            'id_plan_tarifario' => 'Id Plan Tarifario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCondicionPlan()
    {
        return $this->hasOne(CatCondicionesPlan::className(), ['id_condicion_plan' => 'id_condicion_plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlanTarifario()
    {
        return $this->hasOne(CatTiposPlanesTarifarios::className(), ['id_tipo_plan' => 'id_plan_tarifario']);
    }
}
