function calcularFactor($ancho, $alto, $redimension) {
    var factor = 0;
    if ($ancho >= $alto) {
        factor = $redimension / $ancho;
    } else if ($ancho <= $alto) {
        factor = $redimension / $alto;
    }
    
    return factor;
}

