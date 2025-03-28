<?php 
  require_once("includes/config.php");

  require_once("includes/ayuda/ayudaForm.php");
  
  $tituloPagina = 'Ayuda - conecta65';
  
  $form = new ayudaForm(); // instancia del formulario de ayuda
  
  $htmlFormAyuda = $form->Manage();
  
  $contenidoPrincipal = <<<EOS
    <p>$mensaje</p>
    <h3>¿Necesitas ayuda?</h3>
    <p>Ponte en contacto con nuestro equipo para que podamos ayudarte.</p>
    $htmlFormAyuda
  EOS;
  
  require("includes/comun/plantilla.php");
?>