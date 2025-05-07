<?php

// Incluir la configuración general del sistema
require_once("includes/config.php");

use includes\application;
use includes\foroNoticias\foroNoticias;

function mostrar(): string {
    

    $MensajesForo = new foroNoticias();
    $htmlListado =  $MensajesForo->generarMensajes();
        

    return $htmlListado;
}

?>

<?php


$tituloPagina = 'Mi perfil - Conecta65';
$contenidoPrincipal = mostrar();
require("includes/comun/plantilla.php");
?>
