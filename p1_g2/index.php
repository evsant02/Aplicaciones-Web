<?php
// Incluye el archivo de configuración (gestión de sesiones, conexión a BD, etc.)
require_once("includes/config.php");

// Define el título de la página
$tituloPagina = 'Portada';

// Obtiene la instancia de la aplicación (probablemente un patrón Singleton)
$app = Application::getInstance();

// Recupera un mensaje almacenado en la petición (puede ser un mensaje de error o confirmación)
$mensaje = $app->getAtributoPeticion('mensaje');

// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    // Si la sesión está iniciada, muestra la bienvenida sin el botón de inicio de sesión
    $contenidoPrincipal = <<<EOS
    <div style="text-align: center; padding: 20px;">
        <img src="img/logo.jpeg" alt="Logo de la organización" style="max-width: 200px;">
        <h1>Bienvenido a Conecta65</h1>
        <p>Una plataforma web diseñada para fomentar el envejecimiento activo y combatir la soledad en personas mayores.</p> 
        <p>A través de actividades creativas y colaborativas con propósito social, promovemos la conexión intergeneracional y la solidaridad comunitaria.</p>
        <p>$mensaje</p>
    </div>
    EOS;
} else {
    // Si la sesión no está iniciada, muestra la bienvenida con el botón de inicio de sesión
    $contenidoPrincipal = <<<EOS
    <div style="text-align: center; padding: 20px;">
        <img src="img/logo.jpeg" alt="Logo de la organización" style="max-width: 200px;">
        <h1>Bienvenido a Conecta65</h1>
        <p>Una plataforma web diseñada para fomentar el envejecimiento activo y combatir la soledad en personas mayores.</p> 
        <p>A través de actividades creativas y colaborativas con propósito social, promovemos la conexión intergeneracional y la solidaridad comunitaria.</p>
        <p>$mensaje</p>
        <a href="login.php" style="display: inline-block; padding: 10px 20px; margin-top: 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
            Iniciar Sesión
        </a>
    </div>
    EOS;
}

// Incluye la plantilla para estructurar la página con el contenido generado
require("includes/comun/plantilla.php");
?>
