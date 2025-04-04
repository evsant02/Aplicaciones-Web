<?php

// Incluir la configuración general del sistema
require_once("includes/config.php");

// Incluir la clase que gestiona el formulario de creación de actividades
//require_once("includes/crearActividad/crearActividadForm.php");

use includes\crearActividad\crearActividadForm;

// Definir el título de la página
$tituloPagina = 'Nueva Actividad';

// Crear una instancia del formulario de creación de actividad
$form = new crearActividadForm();

// Generar el formulario en HTML
$htmlFormLogin = $form->Manage();

// Definir el contenido principal de la página con el formulario de creación de actividad
$contenidoPrincipal = <<<EOS
<h1>Nueva Actividad</h1>
$htmlFormLogin
EOS;

// Incluir la plantilla general para mostrar la página con el formulario
require("includes/comun/plantilla.php");

?>
