<?php

// Incluye el archivo de configuración para gestionar la sesión
require_once("includes/config.php");

// Elimina todas las variables de sesión
unset($_SESSION);

// Destruye la sesión actual
session_destroy(); 

// Define el título de la página
$tituloPagina = 'Salir del sistema';

// Contenido principal de la página de cierre de sesión
$contenidoPrincipal=<<<EOS
	<h1>Hasta pronto!</h1>
	<p>Has cerrado sesión correctamente. <a href="index.php">Volver a la página de inicio</a></p>
	    <div class="welcome-container">
        <img src="img/logo.jpeg" alt="Logo de la organización" class="logo">
    </div>
EOS;

// Carga la plantilla para mostrar la página con el contenido definido
require("includes/comun/plantilla.php");
?>
