<?php

use app\models\VenEntClientes;
use app\modules\ModUsuarios\models\Utils;
class VenEntClientesExtend extends VenEntClientes
{

    /**
     * Guarda un cliente 
     */
    public function guardarCliente($nombre, $idTipoCliente, $txtRazonSocial, $txtRfc){
        $this->txt_nombre = $nombre;
        $this->id_tipo_cliente = $idTipoCliente;
        $this->txt_razon_social = $txtRazonSocial;
        $this->txt_rfc = $txtRfc;
        $this->fch_creacion = Utils::getFechaActual();

        return $this->save() ? $this: null;
    }

}