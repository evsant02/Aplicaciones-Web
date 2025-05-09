<?php

// Incluir la configuración general del sistema
require_once("includes/config.php");

use includes\application;
use includes\foroNotificaciones\foroNotificaciones;

function mostrar(): string {
    

    $MensajesForo = new foroNotificaciones();
    $htmlListado =  $MensajesForo->generarMensajes();
        

    return $htmlListado;
}

?>

<?php


$tituloPagina = 'Notificaciones';
$contenidoPrincipal = mostrar();
require("includes/comun/plantilla.php");
?>
