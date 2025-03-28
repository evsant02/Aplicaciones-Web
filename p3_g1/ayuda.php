<?php 
  require_once("includes/config.php");

  require_once("includes/ayuda/ayudaForm.php");
  
  $tituloPagina = 'Ayuda - conecta65';

  // Obtiene la instancia de la aplicación (probablemente un patrón Singleton)
  $app = Application::getInstance();

  // Recupera un mensaje almacenado en la petición (puede ser un mensaje de error o confirmación)
  $mensaje = $app->getAtributoPeticion('mensaje');
  
  $form = new ayudaForm(); // instancia del formulario de ayuda
  
  $htmlFormAyuda = $form->Manage();
  
  $contenidoPrincipal = <<<EOS

    <div class="mensaje-confirmacion" style="
    text-align: center;
    font-size: 1.3em;
    color: #2c3e50;
    margin: 30px auto;
    padding: 25px;
    background-color: #e8f4fc;
    border-radius: 10px;
    border-left: 6px solid #4CAF50;
    max-width: 75%;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
">
    <p>$mensaje</p>
</div>
    <h3>¿Necesitas ayuda?</h3>
    <p>Ponte en contacto con nuestro equipo para que podamos ayudarte.</p>
    $htmlFormAyuda
  EOS;
  
  require("includes/comun/plantilla.php");
?>