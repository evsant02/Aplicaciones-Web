<?php
// Incluye el archivo de configuración (gestión de sesiones, conexión a BD, etc.)
require_once("includes/config.php");

use includes\application;

$tituloPagina = 'Error 404 - Página no encontrada';

// Obtiene instancia de la aplicación
$app = Application::getInstance();

// Contenido principal con mensaje de error
$contenidoPrincipal = <<<EOS
    <link rel="stylesheet" href="css/error404.css">

    <div class="error-container">
        <h1>404</h1>
        <h2>¡Ups! Página no encontrada</h2>
        <p>La página que estás buscando no existe o ha ocurrido un error inesperado.</p>
        <a href="index.php" class="btn-volver">Volver al inicio</a>
    </div>
EOS;

// Carga la plantilla general con este contenido
require("includes/comun/plantilla.php");
?>
