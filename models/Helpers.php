<?php
namespace app\models;

class Helpers
{
    public static function validarDiaEntrega($fecha)
    {

        $dia = Calendario::getDayName($fecha);

        if ($dia == "Domingo") {
            $tiempo = strtotime($fecha . "+1 day");
            $fecha = date('d-m-Y', $tiempo);
            $fecha = self::validarDiaEntrega($fecha);
        }


        return $fecha;


    }

    public static function getFechaEntrega($fecha){
        $tiempo = strtotime($fecha. "+2 day");
        $fecha = date('d-m-Y', $tiempo);

        return self::validarDiaEntrega($fecha);
    }
}