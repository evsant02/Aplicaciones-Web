<?php
namespace includes\actividadesFiltradas;

require_once("includes/config.php");
 use includes\application;

class filtrarForm
{
    public function mostrar()
    {
        $app = application::getInstance();
        $userId = $app->getUserDTO()->tipo();
        $fechaMinima = date('Y-m-d\TH:i');
        echo '<div class="filtro-container-moderno">';
        echo '<form id="filtraFecha">';
        echo '<div class="filtro-fila">';
        echo '<div class="filtro-grupo">';
        echo '<label for="fechaInicio"><strong>Desde:</strong></label>';
        if($userId != 0){
            echo '<input type="date" id="fechaInicio" name="fechaInicio" min="' . $fechaMinima . '" class="filtro-input-moderno">';
        }else{
            echo '<input type="date" id="fechaInicio" name="fechaInicio" class="filtro-input-moderno">';
        }
        echo '</div>';
        
        // Hasta
        echo '<div class="filtro-grupo">';
        echo '<label for="fechaFinal"><strong>Hasta:</strong></label>';
        echo '<input type="date" id="fechaFinal" name="fechaFinal" class="filtro-input-moderno">';
        echo '</div>';
        
        echo '</div>'; // Cierra fila 1
        
        // Búsqueda
        echo '<div class="filtro-fila">';
        echo '<div class="filtro-grupo">';
        echo '<label for="texto"><strong>Búsqueda por palabra clave:</strong></label>';
        echo '<input type="text" id="texto" name ="texto" class="filtro-input-moderno">';
        echo '</div>';
        echo '</div>';
        
        // Categorías en línea
        echo '<div>';
        echo '<label><strong>Categorías:</strong></label>';
        echo '<div class="filtro-categorias-linea">';
        echo '<label><input type="checkbox" class="filtro-check" name="tipo" value="Salud"> Salud &nbsp;</label>';
        echo '<label><input type="checkbox" class="filtro-check" name="tipo" value="Deporte"> Deporte &nbsp;</label>';
        echo '<label><input type="checkbox" class="filtro-check" name="tipo" value="Cultura"> Cultura &nbsp;</label>';
        echo '<label><input type="checkbox" class="filtro-check" name="tipo" value="Tecnologia"> Tecnología &nbsp;</label>';
        echo '<label><input type="checkbox" class="filtro-check" name="tipo" value="Habilidades"> Habilidades &nbsp;</label>';
        echo '</div>';
        echo '</div>';
        
        // Botón Filtrar
        echo '<div class="filtro-boton-moderno">';
        echo '<button type="button" id="botonFiltro">Filtrar</button>';
        echo '</div>';
        
        echo '</form>';
        
        return ob_get_clean();
    }
}
?>