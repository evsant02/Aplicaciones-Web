<?php

// Incluye la configuración de la aplicación (base de datos, constantes, etc.)
require_once("includes/config.php");

// Incluye la clase o lógica del formulario de inicio de sesión
require_once("includes/login/loginForm.php");

// Título de la página
$tituloPagina = 'Acceso al sistema';

// Crea una instancia del formulario de login
$form = new loginForm();

// Genera el HTML del formulario de login
$htmlFormLogin = $form->Manage();

// Contenido principal de la página: título + formulario de login
$contenidoPrincipal = <<<EOS
<div class="formulario">
<h1>Login de usuario</h1>
$htmlFormLogin
</div>
EOS;

// Incluye la plantilla base (header, footer, estructura común)
require("includes/comun/plantilla.php");

?>