<?php 
  require_once("includes/config.php");

  use includes\donar\donarForm;
  
  $tituloPagina = 'Haz una donación - conecta65';
  
  $form = new donarForm(); 
  
  $htmlFormDonar = $form->Manage(); 
  
  $contenidoPrincipal = <<<EOS
  <div class="default">
  <h1>Haz una donación para apoyar nuestra iniciativa!</h1>
  $htmlFormDonar 
  </div>
  EOS; 
  
  require("includes/comun/plantilla.php");
?>