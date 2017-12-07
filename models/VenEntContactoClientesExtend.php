<?php

use app\models\VenEntContactoClientes;
use app\modules\ModUsuarios\models\Utils;


class VenEntContactoClientesExtend extends VenEntContactoClientes
{

    /**
     * Guarda un contacto para el cliente 
     */
    public function guardarContacto($idCliente, $nombre, $apellidoP, $apellidoM, $numCelular, $numeroOficina, $extension, $numeroExtra, $txtEmail, $fchNacimiento){
        $this->id_cliente = $idCliente;
        $this->txt_nombre = $nombre;
        $this->txt_apellido_paterno = $apellidoP;
        $this->txt_apellido_materno = $apellidoM;
        $this->txt_numero_celular = $numCelular;
        $this->txt_numero_oficina = $numeroOficina;
        $this->txt_extension = $extension;
        $this->txt_numero_extra = $numeroExtra;
        $this->txt_email = $txtEmail;
        $this->fch_nacimiento = Utils::changeFormatDateInput($fchNacimiento);        

        return $this->save() ? $this: null;
    }

}