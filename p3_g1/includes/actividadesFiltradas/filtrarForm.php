<?php
namespace includes\actividadesFiltradas;

require_once("includes/config.php");

class filtrarForm
{
    public function mostrar()
    {
        ob_start(); // Iniciar buffer de salida
        
        echo '<div id="filtros">';
        echo '<form id="filtraFecha">';
        echo '<label for="fechaInicio">Desde:</label><br>';
        echo '<input type="date" id="fechaInicio" name="fechaInicio"><br><br>';
        echo '<label for="fechaFinal">Hasta:</label><br>';
        echo '<input type="date" id="fechaFinal" name="fechaFinal"><br><br>';
        echo '<label for="texto">Búsqueda por palabra clave:</label><br>';
        echo '<input type="text" id="texto" name ="texto"><br><br>';
        echo '<p><label>Categorías:</label><br></p>';
        echo '<label><input type="checkbox" class="filtro-check" name="tipo" value="Deporte">Deporte &nbsp;</label>';
        echo '<label><input type="checkbox" class="filtro-check" name="tipo" value="Salud">Salud &nbsp;</label>';
        echo '<label><input type="checkbox" class="filtro-check" name="tipo" value="Cultura">Cultura &nbsp;</label>';
        echo '<label><input type="checkbox" class="filtro-check" name="tipo" value="Tecnologia">Tecnología &nbsp;</label>';
        echo '<label><input type="checkbox" class="filtro-check" name="tipo" value="Habilidades">Habilidades</label>';
        echo '<br><br>';
        echo '<button type="button" id="botonFiltro">Filtrar</button>';
        echo '</form>';
        echo '</div>';
        
        return ob_get_clean(); // Devolver el contenido del buffer
    }
}
?>