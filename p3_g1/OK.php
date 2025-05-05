<?php
require_once("includes/config.php");

use includes\application;
use includes\donacion\donacionDTO;
use includes\donacion\donacionAppService;

$app = application::getInstance();

$tituloPagina = 'Donación exitosa - conecta65';

// Recuperar cantidad de los atributos de petición
$cantidad = $app->getAtributoPeticion('donacion_cantidad');

if ($cantidad !== null && $cantidad > 0) {
    // Registrar en BD
    $donacion = new donacionDTO(0, $cantidad);
    $donacionService = donacionAppService::GetSingleton();
    $donacionId = $donacionService->create($donacion);
    
    $mensajeExito = "Hemos recibido correctamente tu donación de $cantidad €.";
} else {
    $mensajeExito = "Hemos recibido correctamente tu donación.";
}

$contenidoPrincipal = <<<EOS
<div class="default">
    <h1>¡Donación realizada con éxito!</h1>
    
    <div class="donation-result success">
        <p>$mensajeExito</p>
        
        <p>Gracias por apoyar nuestra iniciativa. Tu contribución nos ayuda a seguir adelante.</p>
        
        <a href="index.php"><button>Volver al inicio</button></a>
        <a href="donar.php"><button>Hacer otra donación</button></a>
    </div>
</div>
EOS;

require("includes/comun/plantilla.php");