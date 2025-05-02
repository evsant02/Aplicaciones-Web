<?php
// Incluye el archivo de configuración (gestión de sesiones, conexión a BD, etc.)
require_once("includes/config.php");

use includes\application;

// Define el título de la página
$tituloPagina = 'Portada';

// Obtiene la instancia de la aplicación (probablemente un patrón Singleton)
$app = Application::getInstance();

// Recupera un mensaje almacenado en la petición (puede ser un mensaje de error o confirmación)
$mensaje = $app->getAtributoPeticion('mensaje');

$contenidoPrincipal = <<<EOS
    <div class="welcome-container">
        <p>$mensaje</p>
        <img src="img/logo.jpeg" alt="Logo de la organización" class="logo">
        <h1>Bienvenido a Conecta65</h1>
        <p>Una plataforma web diseñada para fomentar el envejecimiento activo y combatir la soledad en personas mayores.</p> 
        <p>A través de actividades creativas y colaborativas con propósito social, promovemos la conexión intergeneracional y la solidaridad comunitaria.</p>
EOS;

if (!$app->isUserLogged()) {
    $contenidoPrincipal .= <<<EOS
        <a href="login.php" class="login-button">
            Iniciar Sesión
        </a>
    EOS;
}

$contenidoPrincipal .= <<<EOS
    </div>
EOS;

// Incluye la plantilla para estructurar la página con el contenido generado
require("includes/comun/plantilla.php");
?>