<?php

// Incluye la configuración de la aplicación (base de datos, constantes, etc.)
require_once("includes/config.php");

use includes\login\registerForm;

// Título de la página
$tituloPagina = 'Registro en el sistema';

// Crea una instancia del formulario de registro
$form = new registerForm();

// Genera el HTML del formulario de registro
$htmlFormRegistro = $form->Manage();

// Contenido principal de la página: título + formulario de registro
$contenidoPrincipal = <<<EOS
<div class="formulario">
<h1>Login de usuario</h1>
$htmlFormRegistro
</div>
EOS;

// Incluye la plantilla base (header, footer, estructura común)
require("includes/comun/plantilla.php");

?>