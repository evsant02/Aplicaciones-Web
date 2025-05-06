<?php
namespace includes\comun;

require_once("includes/config.php");

class barraLateral
{
    public function mostrar()
    {
        ob_start(); // Iniciar buffer de salida
        
        echo '<div id="barralateral" class="sidebar">';
        echo '<form id="filtraFecha" style="padding: 10px; color: white;">';
        echo '<label for="fechaInicio">Desde:</label><br>';
        echo '<input type="date" id="fechaInicio" name="fechaInicio"><br><br>';
        echo '<label for="fechaFinal">Hasta:</label><br>';
        echo '<input type="date" id="fechaFinal" name="fechaFinal"><br><br>';
        //echo '<label for="texto">Búsqueda por palabra clave:</label><br>';
        //echo '<input type="text" id="texto" name ="texto"<br><br>';
        echo '<button type="button" id="botonFiltro">Filtrar</button>';
        echo '</form>';
        echo '</div>';
        
        return ob_get_clean(); // Devolver el contenido del buffer
    }
}
