<?php

include __DIR__ . "/../comun/formBase.php";

class ayudaForm extends formBase {
    public function __construct() {
        parent::__construct('ayudaForm');
    }
    
    protected function CreateFields($datos) {

      $html = <<<EOF
      <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required>
        
        <br><br>
        
        <label for="email">Dirección de email:</label><br>
        <input type="email" id="email" name="email" required>
        
        <br><br>
        
        <fieldset>
            <legend>Motivo de la consulta:</legend>
            <input type="radio" id="evaluacion" name="motivo" value="Evaluación" required>
            <label for="evaluacion">Evaluación</label>
            
            <input type="radio" id="sugerencias" name="motivo" value="Sugerencias">
            <label for="sugerencias">Sugerencias</label>
            
            <input type="radio" id="criticas" name="motivo" value="Críticas">
            <label for="criticas">Críticas</label>
        </fieldset>
        
        <br>
        
        <label for="consulta">Escriba su consulta:</label><br>
        <textarea id="consulta" name="consulta" rows="4" cols="80" required></textarea>
        
        <br><br>
        
        <input type="checkbox" id="terminos" name="terminos" required>
        <label for="terminos">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio</label>
        
        <br><br>
                
        <input type="reset" name="borrar" value="Borrar formulario">
        <input type="submit" name="enviar" value="Enviar">
      EOF;
    
      return $html;

    }

  /*  protected function Process($datos) {
        $errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $email = trim($datos['email'] ?? '');
        $motivo = trim($datos['motivo'] ?? '');
        $consulta = trim($datos['consulta'] ?? '');

        if (empty($nombre)) {
            $errores[] = "El nombre no puede estar vacío.";
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Debe proporcionar un correo válido.";
        }
        if (empty($motivo)) {
            $errores[] = "Debe seleccionar un motivo de consulta.";
        }
        if (empty($consulta)) {
            $errores[] = "La consulta no puede estar vacía.";
        }

        if (!empty($errores)) {
            return $errores;
        }

        // Configurar correo
        $destinatario = "correo@containers.fdi.ucm.es";
        $asunto = "Consulta desde el formulario";
        $mensaje = "Nombre: $nombre\n";
        $mensaje .= "Email: $email\n";
        $mensaje .= "Motivo: $motivo\n";
        $mensaje .= "Consulta: $consulta\n";

        $headers = "From: $email" . "\r\n";
        $headers .= "Reply-To: $email" . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8";

        if (mail($destinatario, $asunto, $mensaje, $headers)) {
            return "Gracias por tu consulta. Nos pondremos en contacto contigo pronto.";
        } else {
            return ["Hubo un error al enviar el correo. Inténtelo de nuevo más tarde."];
        }
    }*/
}

?>
