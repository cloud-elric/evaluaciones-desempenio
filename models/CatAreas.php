<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_areas".
 *
 * @property string $id_area
 * @property string $txt_nombre
 * @property string $b_habilitado
 *
 * @property RelUsuarioArea[] $relUsuarioAreas
 */
class CatAreas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_areas';
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_area' => 'Id Area',
            'txt_nombre' => 'Txt Nombre',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelUsuarioAreas()
    {
        return $this->hasMany(RelUsuarioArea::className(), ['id_area' => 'id_area']);
    }
}
