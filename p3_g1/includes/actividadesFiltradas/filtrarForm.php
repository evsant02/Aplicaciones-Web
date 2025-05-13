<?php
namespace includes\actividadesFiltradas;

require_once("includes/config.php");

class filtrarForm
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
        echo '<label for="texto">Búsqueda por palabra clave:</label><br>';
        echo '<input type="text" id="texto" name ="texto"><br><br>';
        echo '<label>Categorías:</label><br>';
        echo '<label><input type="checkbox" class="filtro-btn" name="tipo" value="Deporte">Deporte</label>';
        echo '<label><input type="checkbox" class="filtro-btn" name="tipo" value="Salud">Salud</label>';
        echo '<label><input type="checkbox" class="filtro-btn" name="tipo" value="Cultura">Cultura</label>';
        echo '<label><input type="checkbox" class="filtro-btn" name="tipo" value="Tecnologia">Tecnología</label>';
        echo '<label><input type="checkbox" class="filtro-btn" name="tipo" value="Habilidades">Habilidades</label>';
        echo '<br><br>';
        echo '<button type="button" id="botonFiltro">Filtrar</button>';
        echo '</form>';
        echo '</div>';
        
        return ob_get_clean(); // Devolver el contenido del buffer
    }
}
?>