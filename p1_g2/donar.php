<?php 
  require_once("includes/config.php");

  require_once("includes/donar/donarForm.php");
  
  $tituloPagina = 'Haz una donación - conecta65';
  
  $form = new donarForm();
  
  $htmlFormLogin = $form->Manage();
  
  $contenidoPrincipal = <<<EOS
  <h1>Haz una donación para apoyar nuestra iniciativa!</h1>
  $htmlFormLogin
  EOS;
  
  require("includes/comun/plantilla.php");
?>