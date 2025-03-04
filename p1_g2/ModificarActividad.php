<?php

require_once("includes/config.php");

require_once("includes/modificarActividad/modificarActividadForm.php");

$tituloPagina = 'Modificar Actividad';

$form = new modificarActividadForm();

$htmlFormLogin = $form->Manage();

$contenidoPrincipal = <<<EOS
<h1>Modificar Actividad</h1>
$htmlFormLogin
EOS;

require("includes/comun/plantilla.php");
?>
