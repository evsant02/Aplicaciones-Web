<?php 
  require_once("includes/config.php");

  require_once("includes/donar/donarForm.php");
  
  $tituloPagina = 'Haz una donación - conecta65';
  
  $form = new donarForm(); // instancia de la clase donarForm
  
  $htmlFormDonar = $form->Manage(); 
  
  $contenidoPrincipal = <<<EOS
  <h1>Haz una donación para apoyar nuestra iniciativa!</h1>
  $htmlFormDonar 
  EOS; 
  
  require("includes/comun/plantilla.php");
?>