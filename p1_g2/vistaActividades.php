
<?php
//require_once("includes/config.php"); //ESTA FUNCIONALIDAD NO HACE USO DE LA BBDD TODAVÍA


require_once("includes/mostrarActividades/actividadesDisponibles.php");


$tituloPagina = 'Actividades disponibles';
$form = new actividadesDisponibles();
$htmlForm = $form->Manage();

$contenidoPrincipal = <<<EOS
<h1>Actividades disponibles</h1>
$htmlForm
EOS;

require("includes/comun/plantilla.php");
?>

