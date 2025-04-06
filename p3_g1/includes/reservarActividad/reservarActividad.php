<?php

namespace includes\reservarActividad;

use includes\actividad\actividadAppService;
use includes\actividadesusuario\actividadesusuarioAppService;
use includes\application;

require_once("includes/config.php");
//require_once( __DIR__ . "/../actividad/actividadAppService.php");
//require_once( __DIR__ . "/../actividades-usuario/actividadesusuarioAppService.php");

class reservarActividad
{
    private $actividad;

    public function __construct($actividad = null) {
        $this->actividad = $actividad;
    }
    

    // Método que construye el formulario de detalles y la funcionalidad de reserva
    public function Inicializacion(){

        $app = application::getInstance();
        $user = $app->getUserDTO();
        $actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();
        $actividadAppService = actividadAppService::GetSingleton();

        echo '<link rel="stylesheet" type="text/css" href="CSS/estiloActividad.css">';  //uso del css que da estilo a la actividad


        if ($this->actividad == null) {
            return "<p>Actividad no encontrada.</p>";
        }

        $fechaHora = new \DateTime($this->actividad->fecha_hora());

        $html = <<<EOF
        <div class="actividad">
            <div class="actividad-img">
                <img src="{$this->actividad->foto()}" alt="Imagen de la actividad">
            </div>
            <div class="actividad-detalles">
                <h1>{$this->actividad->nombre()}</h1>
                <p><strong>Descripción:</strong> {$this->actividad->descripcion()}</p>
                <p><strong>Ubicación:</strong> {$this->actividad->localizacion()}</p>
                <p><strong>Fecha y hora:</strong> {$fechaHora->format('d-m-Y H:i')}</p>
                <p><strong>Aforo:</strong> {$this->actividad->aforo()}</p>
                <p><strong>Plazas ya reservadas:</strong> {$this->actividad->ocupacion()}</p>
        EOF;

        $mensaje = null;

        if (!$actividadUsuarioAppService->isRegistrado($user->id(), $this->actividad->id())) {        
            // Reserva  (si el usuario no está registrado)
            // Mostrar formulario de reserva si hay plazas disponibles
            $html .= '<form method="post">'; 
            $html .= '<button type="submit" name="reservar">Reservar mi plaza</button>';
            $html .= '</form>';
        // Mostrar mensaje de reserva realizada si el formulario ha sido enviado
            if (isset($_POST['reservar'])) {
                $mensaje = $this->procesarReserva($user->id()); // Llamamos a la función de reserva
            }
        }
        else {
            $html .= '<form method="post">';  
            $html .= '<input type="hidden" name="id" value="' . $this->actividad->id() . '">';
            $html .= '<button type="submit" name="bajaActividad">Darse de baja</button>';
            $html .= '</form>';

            if (isset($_POST['bajaActividad'])) {
                $mensaje = $this->bajaActividad($user->id()); // Llamamos a la función de darse de baja
            }
        }

        // Se redirige a la página principal con un mensaje de éxito

        // Se almacena un mensaje de éxito en la sesión para mostrarlo al usuario
        $app = application::getInstance();  

        $app->putAtributoPeticion('mensaje', $mensaje);
               
       // $html .= "</div></div>"; 
        return $html;
    }

    // Procesar la reserva de la actividad
    private function procesarReserva($id_usuario)    {
        
        $actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();
        $actividadAppService = actividadAppService::GetSingleton();
        $actividadAppService->annadirusuario($this->actividad->id());
        $actividadUsuarioAppService->apuntarUsuario($this->actividad->id(), $id_usuario);

        $mensaje =  "¡Reserva realizada con éxito!";
        // Recargar la página
        header("Location: ".$_SERVER['REQUEST_URI']);

        return $mensaje;
    }


    private function bajaActividad($id_usuario) {

        $actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();
        $actividadAppService = actividadAppService::GetSingleton();
        $actividadAppService->borrarUsuario($this->actividad->id());
        $actividadUsuarioAppService->bajaUsuario($this->actividad->id(), $id_usuario);

        $mensaje =  '<p>Se te ha dado de baja en la actividad.</p>';
        // Recargar la página
        header("Location: ".$_SERVER['REQUEST_URI']);
        //exit(); 

        return $mensaje;
    }

}
?>
