<?php

require_once("includes/config.php");

require_once("includes/editarActividad/listaActividades.php");

$tituloPagina = 'Actividades disponibles';

$form = new listaActividades();

$htmlFormLogin = $form->Manage();

$contenidoPrincipal = <<<EOS
<h1>Actividades disponibles</h1>
$htmlFormLogin
EOS;

require("includes/comun/plantilla.php");
?>
