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

    protected function Process($datos) {
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

        // Configuración para el envío de correo a través del servicio VPN
        $destinatario = "correo@containers.fdi.ucm.es";
        $asunto = "Consulta desde el formulario de ayuda";
        $mensaje = "Nombre: $nombre\n";
        $mensaje .= "Email: $email\n";
        $mensaje .= "Motivo: $motivo\n";
        $mensaje .= "Consulta: $consulta\n";

        // Configuración adicional para el servidor de correo
        $headers = [
            'From' => $email,
            'Reply-To' => $email,
            'Content-Type' => 'text/plain; charset=UTF-8',
            'X-Mailer' => 'PHP/' . phpversion()
        ];

        // Configuración del servidor SMTP para la VPN
        ini_set("SMTP", "mail.containers.fdi.ucm.es");
        ini_set("smtp_port", "587");
        ini_set("sendmail_from", $email);

        // Envío del correo
        $mailSent = mail($destinatario, $asunto, $mensaje, $headers);

        // Restaurar configuración original (opcional)
        ini_restore("SMTP");
        ini_restore("smtp_port");
        ini_restore("sendmail_from");

         // Se redirige a la página principal con un mensaje de éxito
        $result = 'ayuda.php';

        // Se almacena un mensaje de éxito en la sesión para mostrarlo al usuario
        $app = application::getInstance();        

        if ($mailSent) {
            $mensaje = "Gracias por tu consulta. Nos pondremos en contacto contigo pronto.";
        } else {
            $message = "Hubo un error al enviar el correo. Inténtelo de nuevo más tarde.";
        }

        $app->putAtributoPeticion('mensaje', $mensaje);

        return $result;
    }
}
?>