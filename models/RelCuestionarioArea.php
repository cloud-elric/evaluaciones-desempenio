<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_cuestionario_area".
 *
 * @property string $id_cuestionario
 * @property string $id_area
 *
 * @property CatAreas $idArea
 * @property EntCuestionario $idCuestionario
 */
class RelCuestionarioArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_cuestionario_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cuestionario', 'id_area'], 'required'],
            [['id_cuestionario', 'id_area'], 'integer'],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => CatAreas::className(), 'targetAttribute' => ['id_area' => 'id_area']],
            [['id_cuestionario'], 'exist', 'skipOnError' => true, 'targetClass' => EntCuestionario::className(), 'targetAttribute' => ['id_cuestionario' => 'id_cuestionario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cuestionario' => 'Id Cuestionario',
            'id_area' => 'Id Area',
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
    public function getIdCuestionario()
    {
        return $this->hasOne(EntCuestionario::className(), ['id_cuestionario' => 'id_cuestionario']);
    }
}
