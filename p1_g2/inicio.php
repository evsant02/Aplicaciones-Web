<?php 
  require_once("includes/config.php");

  $tituloPagina = 'Inicio - conecta65';
  
  $contenidoPrincipal = <<<EOS
    <img src="img/inicio.jpg" alt="Personas mayores andando" width="800">
    <div class="botonesIni">
      <button>Ver actividades</button>
      <button>Hacer una donación</button>
    </div>
  EOS;
  
  require("includes/comun/plantilla.php");
?>