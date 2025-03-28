<?php

include __DIR__ . "/../comun/formBase.php";

class ayudaForm extends formBase {
    public function __construct() {
        parent::__construct('ayudaForm');
    }
    
    protected function CreateFields($datos) {
        // Mostrar mensaje de éxito si existe
        $mensaje = '';
        if (isset($datos['mensaje'])) {
            $mensaje = '<div class="mensaje-exito">' . htmlspecialchars($datos['mensaje']) . '</div>';
        }
        
        // Mostrar mensajes de error si existen
        $errores = '';
        if (isset($datos['errores']) && is_array($datos['errores'])) {
            foreach ($datos['errores'] as $error) {
                $errores .= '<div class="mensaje-error">' . htmlspecialchars($error) . '</div>';
            }
        }

        $html = <<<EOF
        {$mensaje}
        {$errores}
        
        <form method="post" action="">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" value="{$this->escape($datos['nombre'] ?? '')}" required>
            
            <br><br>
            
            <label for="email">Dirección de email:</label><br>
            <input type="email" id="email" name="email" value="{$this->escape($datos['email'] ?? '')}" required>
            
            <br><br>
            
            <fieldset>
                <legend>Motivo de la consulta:</legend>
                <input type="radio" id="evaluacion" name="motivo" value="Evaluación" {$this->checked($datos['motivo'] ?? '', 'Evaluación')} required>
                <label for="evaluacion">Evaluación</label>
                
                <input type="radio" id="sugerencias" name="motivo" value="Sugerencias" {$this->checked($datos['motivo'] ?? '', 'Sugerencias')}>
                <label for="sugerencias">Sugerencias</label>
                
                <input type="radio" id="criticas" name="motivo" value="Críticas" {$this->checked($datos['motivo'] ?? '', 'Críticas')}>
                <label for="criticas">Críticas</label>
            </fieldset>
            
            <br>
            
            <label for="consulta">Escriba su consulta:</label><br>
            <textarea id="consulta" name="consulta" rows="4" cols="80" required>{$this->escape($datos['consulta'] ?? '')}</textarea>
            
            <br><br>
            
            <input type="checkbox" id="terminos" name="terminos" {$this->checked($datos['terminos'] ?? '', 'on')} required>
            <label for="terminos">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio</label>
            
            <br><br>
                    
            <input type="reset" name="borrar" value="Borrar formulario">
            <input type="submit" name="enviar" value="Enviar">
        </form>
        EOF;
    
        return $html;
    }

    protected function Process($datos) {
        $errores = [];
        $resultado = [];

        // Recoger y validar datos
        $nombre = trim($datos['nombre'] ?? '');
        $email = trim($datos['email'] ?? '');
        $motivo = trim($datos['motivo'] ?? '');
        $consulta = trim($datos['consulta'] ?? '');
        $terminos = isset($datos['terminos']) ? 'on' : '';

        // Validaciones
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
        if (empty($terminos)) {
            $errores[] = "Debe aceptar los términos y condiciones.";
        }

        if (!empty($errores)) {
            $resultado['errores'] = $errores;
            $resultado['nombre'] = $nombre;
            $resultado['email'] = $email;
            $resultado['motivo'] = $motivo;
            $resultado['consulta'] = $consulta;
            $resultado['terminos'] = $terminos;
            return $resultado;
        }

        // Configuración para el envío de correo
        $destinatario = "correo@containers.fdi.ucm.es";
        $asunto = "Consulta desde el formulario de ayuda";
        $mensaje = "Nombre: $nombre\n";
        $mensaje .= "Email: $email\n";
        $mensaje .= "Motivo: $motivo\n";
        $mensaje .= "Consulta: $consulta\n";

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

        // Restaurar configuración original
        ini_restore("SMTP");
        ini_restore("smtp_port");
        ini_restore("sendmail_from");

        if ($mailSent) {
            $resultado['mensaje'] = "Gracias por tu consulta. Nos pondremos en contacto contigo pronto.";
    
        } else {
            $resultado['errores'] = ["Hubo un error al enviar el correo. Inténtelo de nuevo más tarde."];

        }

        return $resultado;
    }

}