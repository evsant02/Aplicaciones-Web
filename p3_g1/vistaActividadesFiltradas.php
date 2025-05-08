<?php
// Incluir la configuración general del sistema
require_once("includes/config.php");
// Incluir la clase que genera la lista de actividades disponibles
//require_once("includes/mostrarActividades/actividadesDisponibles.php");

use includes\actividadesFiltradas\actividadesFiltradas;
use includes\application;
use includes\comun\barraLateral;
// Definir el título de la página
$tituloPagina = 'Filtros de Actividad';

// Obtiene la instancia de la aplicación (probablemente un patrón Singleton)
$app = Application::getInstance();

// Recupera un mensaje almacenado en la petición (puede ser un mensaje de error o confirmación)
$mensaje = $app->getAtributoPeticion('mensaje');
$barraLateral = new barraLateral();

// Crear una instancia de actividadesDisponibles y generar el listado
//$actividadesFiltradas = new actividadesFiltradas();

if (isset($_GET['ajax'])) {
    header('Content-Type: text/html');
    echo $filtrador->filtrado();
    exit;
}

// Definir el contenido principal de la página

$contenidoPrincipal = <<<EOS
<div class="contenedor-principal">
    <aside class="sidebar-container">
        {$barraLateral->mostrar()}
    </aside>
    
    <main class="contenido-principal">
        <p>$mensaje</p>
        <h1>Actividades filtradas</h1>
        
        <div id="resultadoActividades">
        </div>
    </main>
</div>

<script src="js/lateral.js"></script>
EOS;

// Incluir la plantilla general para mostrar la página con el contenido generado
require("includes/comun/plantilla.php");

?>
