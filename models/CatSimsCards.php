<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_sims_cards".
 *
 * @property string $id_sim_card
 * @property string $txt_token
 * @property string $txt_nombre
 * @property string $txt_clave_sim_card
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntCitas[] $entCitas
 */
class CatSimsCards extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_sims_cards';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_token', 'txt_nombre', 'txt_clave_sim_card', 'txt_descripcion'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_token'], 'string', 'max' => 60],
            [['txt_nombre', 'txt_clave_sim_card'], 'string', 'max' => 150],
            [['txt_descripcion'], 'string', 'max' => 500],
            [['txt_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sim_card' => 'Id Sim Card',
            'txt_token' => 'Txt Token',
            'txt_nombre' => 'Txt Nombre',
            'txt_clave_sim_card' => 'Txt Clave Sim Card',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_sim_card' => 'id_sim_card']);
    }
}
