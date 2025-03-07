<?php
require_once("includes/config.php");

$tituloPagina = 'Portada';
$app = Application::getInstance();
$mensaje = $app->getAtributoPeticion('mensaje');

if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    // Si la sesión está iniciada, muestra el mensaje sin el enlace de login.
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
    // Si la sesión no está iniciada, muestra el mensaje con el enlace de login.
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

require("includes/comun/plantilla.php");
?>