<?php

// Incluir la configuración general del sistema
require_once("includes/config.php");

use includes\mostrarActividades\actividadesDisponibles;
use includes\application;

// Definir el título de la página
$tituloPagina = 'Actividades disponibles';

// Obtiene la instancia de la aplicación (probablemente un patrón Singleton)
$app = Application::getInstance();

// Recupera un mensaje almacenado en la petición (puede ser un mensaje de error o confirmación)
$mensaje = $app->getAtributoPeticion('mensaje');

// Crear una instancia de actividadesDisponibles y generar el listado
$actividadesDisponibles = new actividadesDisponibles();
$htmlListado = $actividadesDisponibles->Inicializacion(); //esto tiene que ser inicializacion

// Definir el contenido principal de la página
$contenidoPrincipal = <<<EOS
<p>$mensaje</p>
<div id="actividades-header">
    <h1>Todas las Actividades Disponibles</h1>
    <a href="vistaActividadesFiltradas.php"><button type="button">Filtrar ☰</button></a>
</div>
$htmlListado
EOS;

// Incluir la plantilla general para mostrar la página con el contenido generado
require("includes/comun/plantilla.php");
?>
