<?php

require_once("includes/config.php");

require_once("includes/crearActividad/crearActividadForm.php");

$tituloPagina = 'Nueva Actividad';

$form = new crearActividadForm();

$htmlFormLogin = $form->Manage();

$contenidoPrincipal = <<<EOS
<h1>Nueva Actividad</h1>
$htmlFormLogin
EOS;

require("includes/comun/plantilla.php");
?>