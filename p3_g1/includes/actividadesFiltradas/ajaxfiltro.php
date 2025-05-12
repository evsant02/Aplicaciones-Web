<?php
//endpoint que recibe la informacion desde el javascript e inicializa el metodo
namespace includes\actividadesFiltradas;
require_once(__DIR__ . "/../config.php");
use includes\actividadesFiltradas\actividadesFiltradas;

header("Content-Type: text/html");

$filtrador = new actividadesFiltradas();
echo $filtrador->filtrado();
