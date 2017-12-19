<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_niveles".
 *
 * @property string $id_nivel
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntRespuestas[] $entRespuestas
 * @property ModUsuariosEntUsuarios[] $modUsuariosEntUsuarios
 * @property RelCuestionarioNiveles[] $relCuestionarioNiveles
 */
class CatNiveles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_niveles';
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
            [['txt_descripcion'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_nivel' => 'Id Nivel',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntRespuestas()
    {
        return $this->hasMany(EntRespuestas::className(), ['id_nivel' => 'id_nivel']);
    }

    public function getEntRespuestasByCuestionario($idCuestionario)
    {
        return $this->hasMany(EntRespuestas::className(), ['id_nivel' => 'id_nivel'])->andWhere(['id_cuestionario'=>$idCuestionario])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModUsuariosEntUsuarios()
    {
        return $this->hasMany(ModUsuariosEntUsuarios::className(), ['id_nivel' => 'id_nivel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelCuestionarioNiveles()
    {
        return $this->hasMany(RelCuestionarioNiveles::className(), ['id_nivel' => 'id_nivel']);
    }
}
