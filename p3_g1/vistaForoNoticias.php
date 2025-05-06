<?php
// Incluir la configuración general del sistema
require_once("includes/config.php");
// Incluir la clase que genera la lista de actividades disponibles
//require_once("includes/mostrarActividades/actividadesDisponibles.php");

use includes\foroNoticias\foroNoticias; 
use includes\application;

// Definir el título de la página
$tituloPagina = 'Foro Noticias';

// Obtiene la instancia de la aplicación (probablemente un patrón Singleton)
$app = Application::getInstance();

// Recupera un mensaje almacenado en la petición (puede ser un mensaje de error o confirmación)
$mensaje = $app->getAtributoPeticion('mensaje');

// Crear una instancia de actividadesDisponibles y generar el listado
$foroNoticias = new foroNoticias();
//CAMBIAR REVISAR
$htmlListado = $foroNoticias->inicializar(); 

// Definir el contenido principal de la página
$contenidoPrincipal = <<<EOS
<p>$mensaje</p>
<h1>Foro de noticias</h1>
$htmlListado
EOS;

// Incluir la plantilla general para mostrar la página con el contenido generado
require("includes/comun/plantilla.php");
?>
