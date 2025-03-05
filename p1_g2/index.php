<?php
require_once("includes/config.php");

$tituloPagina = 'Portada';
$app = Application::getInstance();
$mensaje = $app->getAtributoPeticion('mensaje');

$contenidoPrincipal = <<<EOS
<div style="text-align: center; padding: 20px;">
    
    <img src="img/logo.jpg.jpeg" alt="Logo de la organización" style="max-width: 200px;">

    
    <h1>Bienvenido a Conecta65</h1>
    <p>
        Una plataforma web diseñada para fomentar el envejecimiento activo y combatir la soledad en personas mayores.  
        A través de actividades creativas y colaborativas con propósito social, promovemos la conexión intergeneracional  
        y la solidaridad comunitaria.
    </p>

    
    <p>$mensaje</p>

    
    <a href="login.php" style="display: inline-block; padding: 10px 20px; margin-top: 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
        Iniciar Sesión
    </a>
</div>
EOS;

require("includes/comun/plantilla.php");
?>