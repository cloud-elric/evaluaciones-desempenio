<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_dias".
 *
 * @property string $id_dia
 * @property string $txt_short_name
 * @property string $txt_long_name
 *
 * @property EntHorariosAreas[] $entHorariosAreas
 */
class CatDias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_dias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_short_name'], 'string', 'max' => 10],
            [['txt_long_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_dia' => 'Id Dia',
            'txt_short_name' => 'Txt Short Name',
            'txt_long_name' => 'Txt Long Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntHorariosAreas()
    {
        return $this->hasMany(EntHorariosAreas::className(), ['id_dia' => 'id_dia']);
    }
}
