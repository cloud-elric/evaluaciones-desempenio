<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_cuestionario_niveles".
 *
 * @property string $id_cuestionario
 * @property string $id_nivel
 *
 * @property CatNiveles $idNivel
 * @property EntCuestionario $idCuestionario
 */
class RelCuestionarioNiveles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_cuestionario_niveles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cuestionario', 'id_nivel'], 'required'],
            [['id_cuestionario', 'id_nivel'], 'integer'],
            [['id_nivel'], 'exist', 'skipOnError' => true, 'targetClass' => CatNiveles::className(), 'targetAttribute' => ['id_nivel' => 'id_nivel']],
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
            'id_nivel' => 'Id Nivel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNivel()
    {
        return $this->hasOne(CatNiveles::className(), ['id_nivel' => 'id_nivel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCuestionario()
    {
        return $this->hasOne(EntCuestionario::className(), ['id_cuestionario' => 'id_cuestionario']);
    }
}
