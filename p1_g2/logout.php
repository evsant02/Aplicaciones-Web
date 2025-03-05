<?php

require_once("includes/config.php");

unset($_SESSION);

session_destroy(); 

$tituloPagina = 'Salir del sistema';

$contenidoPrincipal=<<<EOS
	<h1>Hasta pronto!</h1>
	<p>Has cerrado sesión correctamente. <a href="index.php">Volver a la página de inicio</a></p>
EOS;

require("includes/comun/plantilla.php");
?>