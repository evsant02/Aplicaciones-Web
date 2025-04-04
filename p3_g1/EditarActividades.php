<?php

// Incluir la configuración general del sistema
require_once("includes/config.php");

// Incluir la clase que genera la lista de actividades
//require_once("includes/editarActividades/listaActividades.php");

use includes\editarActividades\listaActividades;

// Definir el título de la página
$tituloPagina = 'Actividades disponibles';

// Crear una instancia de ListaActividades y generar el listado
$listaActividades = new listaActividades();
$htmlFormLogin = $listaActividades->generarListado();

// Definir el contenido principal de la página
$contenidoPrincipal = <<<EOS
<h1>Actividades disponibles</h1>
$htmlFormLogin
EOS;

// Incluir la plantilla general para mostrar la página con el contenido generado
require("includes/comun/plantilla.php");

?>