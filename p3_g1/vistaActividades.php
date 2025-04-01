

<?php
// Incluir la configuración general del sistema
require_once("includes/config.php");
// Incluir la clase que genera la lista de actividades disponibles
require_once("includes/mostrarActividades/actividadesDisponibles.php");

// Definir el título de la página
$tituloPagina = 'Actividades disponibles';

// Crear una instancia de actividadesDisponibles y generar el listado
$actividadesDisponibles = new actividadesDisponibles();
$htmlListado = $actividadesDisponibles->generarListado();

// Definir el contenido principal de la página
$contenidoPrincipal = <<<EOS
<h1>Actividades disponibles</h1>
$htmlListado
EOS;

// Incluir la plantilla general para mostrar la página con el contenido generado
require("includes/comun/plantilla.php");
?>
