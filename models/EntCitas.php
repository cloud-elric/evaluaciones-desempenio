<?php

namespace app\models;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;

/**
 * This is the model class for table "ent_citas".
 *
 * @property string $id_cita
 * @property string $id_tipo_tramite
 * @property string $id_equipo
 * @property string $id_area
 * @property string $id_tipo_entrega
 * @property string $id_usuario
 * @property string $id_status
 * @property string $id_estado
 * @property string $id_envio
 * @property string $id_tipo_cliente
 * @property string $id_condicion_plan
 * @property string $id_tipo_plan_tarifario
 * @property string $id_plazo
 * @property string $id_tipo_deposito_garantia
 * @property string $id_tipo_identificacion
 * @property string $b_pago_contra_entrega
 * @property double $num_monto_cod
 * @property double $num_cantidad_deposito
 * @property string $txt_numero_telefonico_nuevo
 * @property string $txt_rfc
 * @property string $txt_email
 * @property string $txt_folio_identificacion
 * @property string $fch_nacimiento
 * @property double $num_costo_equipo 
 * @property string $num_dias_servicio
 * @property string $txt_token
 * @property string $txt_clave_sap_equipo
 * @property string $txt_descripcion_equipo
 * @property string $txt_serie_equipo
 * @property string $txt_iccid
 * @property string $txt_imei
 * @property string $txt_telefono
 * @property string $txt_nombre
 * @property string $txt_apellido_paterno
 * @property string $txt_apellido_materno
 * @property string $txt_numero_referencia
 * @property string $txt_numero_referencia_2
 * @property string $txt_numero_referencia_3
 * @property string $txt_calle_numero
 * @property string $txt_colonia
 * @property string $txt_codigo_postal
 * @property string $txt_municipio
 * @property string $txt_entre_calles
 * @property string $txt_observaciones_punto_referencia
 * @property string $txt_motivo_cancelacion
 * @property string $fch_cita
 * @property string $fch_hora_cita
 * @property string $b_deposito_contra_entrega
 *
 * @property CatAreas $idArea
 * @property CatCondicionesPlan $idCondicionPlan 
 * @property CatEquipos $idEquipo
 * @property CatEstados $idEstado
 * @property CatPlazos $idPlazo 
 * @property CatStatusCitas $idStatus
 * @property CatTiposClientes $idTipoCliente 
 * @property CatTiposDepositosGarantia $idTipoDepositoGarantia 
 * @property CatTiposDepositosGarantia $idTipoIdentificacion
 * @property CatTiposEntrega $idTipoEntrega
 * @property CatTiposPlanesTarifarios $idTipoPlanTarifario
 * @property CatTiposTramites $idTipoTramite
 * @property EntEnvios $idEnvio
 * @property ModUsuariosEntUsuarios $idUsuario
 * @property EntHistorialCambiosCitas[] $entHistorialCambiosCitas
 */
class EntCitas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_citas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
				['num_monto_cod'], 'required',
			 	'when' => function ($model) {
			 		return $model->id_tipo_deposito_garantia==2;
			 	}, 'whenClient' => "function (attribute, value) {
                    
                     return $('#entcitas-id_tipo_deposito_garantia').val()==2;
                 }"
            ],
            [
				['id_tipo_deposito_garantia'], 'required',
			 	'when' => function ($model) {
			 		return $model->num_costo_equipo>0;
			 	}, 'whenClient' => "function (attribute, value) {
                    
                     return $('#entcitas-num_costo_equipo').val()>0;
                 }"
			],
            [['txt_telefono'] , 'unique', 'message'=>'Número teléfonico ya se encuentra utilizado', 'on'=>[ 'createRegistro']],
            [['id_usuario', 'id_status', 'txt_token', 'txt_nombre', 'txt_apellido_paterno', 'txt_apellido_materno', 'txt_telefono', 'txt_email', 
                'fch_nacimiento', 'txt_rfc', 'id_tipo_tramite', 'id_tipo_cliente', 'id_condicion_plan', 'id_tipo_plan_tarifario', 
                'id_plazo', 'id_equipo', 'num_costo_equipo', 'id_tipo_deposito_garantia'], 'required', 'on'=>'create'],
            [['txt_email'], 'email'],
            [['id_tipo_tramite','id_horario','id_estado',  'id_area', 'id_tipo_entrega', 'id_usuario', 'id_status', 'num_dias_servicio', 'txt_token', 'txt_iccid',  'txt_telefono', 'txt_numero_referencia', 'txt_calle_numero', 'txt_colonia', 'txt_codigo_postal', 'txt_municipio', 'txt_entre_calles', 'txt_observaciones_punto_referencia', 'fch_hora_cita'], 'required', 'on'=>'aprobar'],
            [['id_tipo_tramite', 'id_equipo', 'id_area', 'id_tipo_entrega', 'id_usuario', 'id_status', 'id_estado', 'id_envio'], 'integer'],
            [['fch_cita'], 'safe'],
            [['num_dias_servicio', 'fch_hora_cita'], 'string', 'max' => 50],
            [['txt_token'], 'string', 'max' => 60],
            [['txt_clave_sap_equipo'], 'string', 'max' => 200],
            [['txt_descripcion_equipo',  'txt_entre_calles', 'txt_observaciones_punto_referencia'], 'string', 'max' => 500],
            [['txt_serie_equipo', 'txt_iccid', 'txt_imei', 'txt_calle_numero'], 'string', 'max' => 150],
            [['txt_telefono', 'txt_numero_referencia', 'txt_numero_referencia_2', 'txt_numero_referencia_3'], 'string', 'max' => 10],
            [['txt_telefono', 'txt_numero_referencia'], 'string', 'max' => 10, 'min' => 10, 'tooLong' => 'El campo no debe superar 10 dígitos','tooShort' => 'El campo debe ser mínimo de 10 digítos'],
            [['txt_colonia', 'txt_municipio'], 'string', 'max' => 100],
            [['txt_codigo_postal'], 'string', 'max' => 5],
            [['txt_motivo_cancelacion'], 'string', 'max' => 700],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => CatAreas::className(), 'targetAttribute' => ['id_area' => 'id_area']],
            [['id_equipo'], 'exist', 'skipOnError' => true, 'targetClass' => CatEquipos::className(), 'targetAttribute' => ['id_equipo' => 'id_equipo']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => CatEstados::className(), 'targetAttribute' => ['id_estado' => 'id_estado']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => CatStatusCitas::className(), 'targetAttribute' => ['id_status' => 'id_statu_cita']],
            [['id_tipo_entrega'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposEntrega::className(), 'targetAttribute' => ['id_tipo_entrega' => 'id_tipo_entrega']],
            [['id_tipo_tramite'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposTramites::className(), 'targetAttribute' => ['id_tipo_tramite' => 'id_tramite']],
            [['id_envio'], 'exist', 'skipOnError' => true, 'targetClass' => EntEnvios::className(), 'targetAttribute' => ['id_envio' => 'id_envio']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cita' => 'Id Cita',
            'id_tipo_tramite' => 'Tipo de tramite',
            'id_equipo' => 'Equipo',
            'id_area' => 'Área',
            'id_tipo_entrega' => 'Tipo de entrega',
            'id_usuario' => 'Id Usuario',
            'id_status' => 'Estatus',
            'id_estado' => 'Estado',
            'id_envio' => 'Id Envio',
            'id_tipo_cliente' => 'Tipo de cliente',
            'id_condicion_plan' => 'Condición del plan',
            'id_tipo_plan_tarifario' => 'Plan tarifario',
            'id_plazo' => 'Plazo',
            'id_tipo_deposito_garantia' => 'Tipo de deposito',
            'id_tipo_identificacion' => 'Tipo de identificación',
            'b_pago_contra_entrega' => 'Pagar contra entrega',
            'num_monto_cod' => 'Monto de COD',
            'num_cantidad_deposito' => 'Cantidad de deposito',
            'txt_numero_telefonico_nuevo' => 'Número teléfonico nuevo/provicional',
            'txt_rfc' => 'RFC',
            'txt_email' => 'Correo electrónico',
            'txt_folio_identificacion' => 'Folio de identificación',
            'fch_nacimiento' => 'Fecha de nacimiento',
            'num_costo_equipo' => 'Costo de equipo',
            'num_dias_servicio' => 'Días de servicio',
            'txt_token' => 'Txt Token',
            'txt_clave_sap_equipo' => 'Clave sap del equipo',
            'txt_descripcion_equipo' => 'Descripción del equipo',
            'txt_serie_equipo' => 'Serie del equipo',
            'txt_iccid' => 'ICCID',
            'txt_imei' => 'IMEI',
            'txt_telefono' => 'Teléfono',
            'txt_nombre' => 'Nombre',
            'txt_apellido_paterno' => 'Apellido paterno',
            'txt_apellido_materno' => 'Apellido materno',
            'txt_numero_referencia' => 'Número teléfonico de referencia',
            'txt_numero_referencia_2' => 'Número teléfonico de referencia 2',
            'txt_numero_referencia_3' => 'Número teléfonico de referencia 3',
            'txt_calle_numero' => 'Nombre de la calle y número',
            'txt_colonia' => 'Colonia',
            'txt_codigo_postal' => 'C.P.',
            'txt_municipio' => 'Municipio',
            'txt_entre_calles' => 'Entre Calles',
            'txt_observaciones_punto_referencia' => 'Puntos de referencia',
            'txt_motivo_cancelacion' => 'Motivo cancelación',
            'fch_cita' => 'Fecha de la cita',
            'fch_hora_cita' => 'Hora de la cita',
            'num_costo_renta' => 'Costo renta',
            'id_horario'=> 'Horario de entrega',
            'fch_creacion'=>'Fecha creación'
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
    public function getIdEquipo()
    {
        return $this->hasOne(CatEquipos::className(), ['id_equipo' => 'id_equipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstado()
    {
        return $this->hasOne(CatEstados::className(), ['id_estado' => 'id_estado']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatus()
    {
        return $this->hasOne(CatStatusCitas::className(), ['id_statu_cita' => 'id_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoEntrega()
    {
        return $this->hasOne(CatTiposEntrega::className(), ['id_tipo_entrega' => 'id_tipo_entrega']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoTramite()
    {
        return $this->hasOne(CatTiposTramites::className(), ['id_tramite' => 'id_tipo_tramite']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvio()
    {
        return $this->hasOne(EntEnvios::className(), ['id_envio' => 'id_envio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(ModUsuariosEntUsuarios::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntHistorialCambiosCitas()
    {
        return $this->hasMany(EntHistorialCambiosCitas::className(), ['id_cita' => 'id_cita']);
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
    public function getIdPlazo() 
    { 
        return $this->hasOne(CatPlazos::className(), ['id_plazo' => 'id_plazo']); 
    } 

    public function getIdTipoCliente() 
    { 
        return $this->hasOne(CatTiposClientes::className(), ['id_tipo_cliente' => 'id_tipo_cliente']); 
    } 
  
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getIdTipoDepositoGarantia() 
    { 
        return $this->hasOne(CatTiposDepositosGarantia::className(), ['id_tipo_deposito_garantia' => 'id_tipo_deposito_garantia']); 
    } 
  
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getIdTipoIdentificacion() 
    { 
        return $this->hasOne(CatTiposDepositosGarantia::className(), ['id_tipo_deposito_garantia' => 'id_tipo_identificacion']); 
    } 

    /**
    * @return \yii\db\ActiveQuery
    */
   public function getIdTipoPlanTarifario() 
   { 
       return $this->hasOne(CatTiposPlanesTarifarios::className(), ['id_tipo_plan' => 'id_tipo_plan_tarifario']); 
   } 
}
