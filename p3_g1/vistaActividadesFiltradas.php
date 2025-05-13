<?php
// Incluir la configuración general del sistema
require_once("includes/config.php");

use includes\application;
use includes\actividadesFiltradas\filtrarForm;
// Definir el título de la página
$tituloPagina = 'Filtros de Actividad';

// Obtiene la instancia de la aplicación (probablemente un patrón Singleton)
$app = Application::getInstance();

// Recupera un mensaje almacenado en la petición (puede ser un mensaje de error o confirmación)
$mensaje = $app->getAtributoPeticion('mensaje');
//crear la seccion para elegir los filtros
$filtrarForm = new filtrarForm();


if (isset($_GET['ajax'])) {
    header('Content-Type: text/html');
    echo $filtrador->filtrado();
    exit;
}

// Definir el contenido principal de la página

$contenidoPrincipal = <<<EOS
<aside class="filtro-container">
    {$filtrarForm->mostrar()}
</aside>

<main class="contenido-principal">
    <p>$mensaje</p>
    <h1>Actividades filtradas</h1>
    
    <div id="resultadoActividades">
    </div>
</main>

<script src="js/lateral.js"></script>
EOS;

// Incluir la plantilla general para mostrar la página con el contenido generado
require("includes/comun/plantilla.php");

?>
