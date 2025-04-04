
<?php
// Incluir la configuración general del sistema
require_once("includes/config.php");
// Incluir la clase que genera la lista de actividades disponibles
require_once("includes/dirigirActividad/dirigirActividad.php");

$tituloPagina = 'Dirigir Actividad';
$id = $_GET['id'];

// Obtiene la instancia de la aplicación (probablemente un patrón Singleton)
$app = Application::getInstance();

// Recupera un mensaje almacenado en la petición (puede ser un mensaje de error o confirmación)
$mensaje = $app->getAtributoPeticion('mensaje');

$actividadAppService = actividadAppService::GetSingleton();
$actividad = $actividadAppService->getActividadById($id);


$form = new dirigirActividad($actividad);
$htmlForm = $form->Inicializacion();

$contenidoPrincipal = <<<EOS
<p>$mensaje</p>
<h1>Dirigir Actividad</h1>
$htmlForm
EOS;

require("includes/comun/plantilla.php");
?>
