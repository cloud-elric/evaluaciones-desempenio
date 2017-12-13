<?php

namespace app\models;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;

/**
 * This is the model class for table "cat_areas".
 *
 * @property string $id_area
 * @property string $txt_nombre
 * @property string $b_habilitado
 *
 * @property EntRespuestas[] $entRespuestas
 * @property ModUsuariosEntUsuarios[] $modUsuariosEntUsuarios
 * @property RelCuestionarioArea[] $relCuestionarioAreas
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
    public function getEntRespuestas()
    {
        return $this->hasMany(EntRespuestas::className(), ['id_area' => 'id_area']);
    }

    public function getEntRespuestasByCuestionario($idCuestionario)
    {
        return $this->hasMany(EntRespuestas::className(), ['id_area' => 'id_area'])->andWhere(['id_cuestionario'=>$idCuestionario])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModUsuariosEntUsuarios()
    {
        return $this->hasMany(EntUsuarios::className(), ['id_area' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelCuestionarioAreas()
    {
        return $this->hasMany(RelCuestionarioArea::className(), ['id_area' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelUsuarioAreas()
    {
        return $this->hasMany(RelUsuarioArea::className(), ['id_area' => 'id_area']);
    }
}
