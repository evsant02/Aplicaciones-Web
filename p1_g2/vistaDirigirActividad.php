
<?php
//require_once("includes/config.php"); ESTA FUNCIONALIDAD NO HACE USO DE LA BBDD TODAVÍA
require_once("includes/dirigirActividad/dirigirActividad.php");

$tituloPagina = 'Dirigir Actividad';

$form = new dirigirActividad();
$htmlForm = $form->Manage();

$contenidoPrincipal = <<<EOS
<h1>Dirigir Actividad</h1>
$htmlForm
EOS;

require("includes/comun/plantilla.php");
?>
