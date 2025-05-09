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
        echo '<label for="texto">Búsqueda por palabra clave:</label><br>';
        echo '<input type="text" id="texto" name ="texto"><br><br>';
        echo '<label>Categorías:</label><br>';
        echo '<label><input type="checkbox" class="filtro-btn" name="tipo" value="Deporte">Deporte</label>';
        echo '<label><input type="checkbox" class="filtro-btn" name="tipo" value="Salud">Salud</label>';
        echo '<label><input type="checkbox" class="filtro-btn" name="tipo" value="Cultura">Cultura</label>';
        echo '<label><input type="checkbox" class="filtro-btn" name="tipo" value="Tecnologia">Tecnología</label>';
        echo '<br><br>';
        echo '<button type="button" id="botonFiltro">Filtrar</button>';
        echo '</form>';
        echo '</div>';
        
        return ob_get_clean(); // Devolver el contenido del buffer
    }
}
?>
<style>
  .filtro-btn {
    appearance: none;
    -webkit-appearance: none;
    background-color: #f0f0f0;
    border: 2px solid #ccc;
    padding: 10px 20px;
    border-radius: 8px;
    margin: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.2s, border-color 0.2s;
  }

  .filtro-btn:checked {
    background-color: #007BFF;
    color: white;
    border-color: #0056b3;
  }
</style>