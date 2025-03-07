<?php 
  require_once("includes/config.php");

  require_once("includes/ayuda/ayudaForm.php");
  
  $tituloPagina = 'Ayuda - conecta65';
  
  $form = new ayudaForm();
  
  $htmlFormAyuda = $form->Manage();
  
  $contenidoPrincipal = <<<EOS
    <h3>¿Necesitas ayuda?</h3>
    <p>Ponte en contacto con nuestro equipo para que podamos ayudarte.</p>
    $htmlFormAyuda
  EOS;
  
  require("includes/comun/plantilla.php");
?>