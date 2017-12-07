<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_envios".
 *
 * @property string $id_envio
 * @property string $txt_token
 */
class EntEnvios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_envios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_token'], 'required'],
            
            [['txt_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_envio' => 'Id Envio',
            'txt_token' => 'Txt Token',
        ];
    }
}
