<?php
  require_once("includes/config.php");


  //require_once("includes/ayuda/ayudaForm.php");

  use includes\ayuda\ayudaForm;
  use includes\application;
 
  $tituloPagina = 'Ayuda - conecta65';


  // Obtiene la instancia de la aplicación (probablemente un patrón Singleton)
  $app = Application::getInstance();

  // Recupera un mensaje almacenado en la petición (puede ser un mensaje de error o confirmación)
  $mensaje = $app->getAtributoPeticion('mensaje');
 
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
