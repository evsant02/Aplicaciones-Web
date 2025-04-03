<?php

// Incluye la configuración de la aplicación (base de datos, constantes, etc.)
require_once("includes/config.php");

// Incluye la clase o lógica del formulario de registro
//require_once("includes/login/registerForm.php");

use includes\login\registerForm;

// Título de la página
$tituloPagina = 'Registro en el sistema';

// Crea una instancia del formulario de registro
$form = new registerForm();

// Genera el HTML del formulario de registro
$htmlFormRegistro = $form->Manage();

// Contenido principal de la página: título + formulario de registro
$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
$htmlFormRegistro
EOS;

// Incluye la plantilla base (header, footer, estructura común)
require("includes/comun/plantilla.php");

?>