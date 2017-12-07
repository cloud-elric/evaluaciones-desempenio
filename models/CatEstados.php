<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_estados".
 *
 * @property string $id_estado
 * @property string $id_pais
 * @property string $id_area
 * @property string $num_estado
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property double $num_latitud
 * @property double $num_longitud
 * @property string $b_habilitado
 *
 * @property CatAreas $idArea
 * @property CatPaises $idPais
 * @property CatMunicipios[] $catMunicipios
 * @property EntCitas[] $entCitas
 */
class CatEstados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_estados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pais', 'txt_nombre', 'txt_descripcion'], 'required'],
            [['id_pais', 'id_area', 'num_estado', 'b_habilitado'], 'integer'],
            [['num_latitud', 'num_longitud'], 'number'],
            [['txt_nombre'], 'string', 'max' => 45],
            [['txt_descripcion'], 'string', 'max' => 2500],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => CatAreas::className(), 'targetAttribute' => ['id_area' => 'id_area']],
            [['id_pais'], 'exist', 'skipOnError' => true, 'targetClass' => CatPaises::className(), 'targetAttribute' => ['id_pais' => 'id_pais']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estado' => 'Id Estado',
            'id_pais' => 'Id Pais',
            'id_area' => 'Id Area',
            'num_estado' => 'Num Estado',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'num_latitud' => 'Num Latitud',
            'num_longitud' => 'Num Longitud',
            'b_habilitado' => 'B Habilitado',
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
    public function getIdPais()
    {
        return $this->hasOne(CatPaises::className(), ['id_pais' => 'id_pais']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatMunicipios()
    {
        return $this->hasMany(CatMunicipios::className(), ['id_estado' => 'id_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_estado' => 'id_estado']);
    }
}
