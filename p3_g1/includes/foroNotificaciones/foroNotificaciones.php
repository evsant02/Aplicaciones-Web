<?php
namespace includes\foroNotificaciones;

use includes\actividadesmensajes\actividadesmensajesAppService;
use includes\application;

use includes\actividad\actividadAppService;

class foroNotificaciones {


    private $mensajes;

    public function __construct() 
    {
        //esta devuelve las actividades correspondientes a ese usuario
        $this->mensajes= $this->obtenerActividades();
    }


    private function obtenerActividades(){
        //el metodo para que me devuelva el id de las actividades de ese usuario
        //esto sirve para mandar el user->id
        $user = application::getInstance()->getUserDTO(); // se obtienen los datos del usuario
        $MensajesUsuarioService = actividadesmensajesAppService::GetSingleton();
        $MensajesUsuario = $MensajesUsuarioService->getMensajesPorUsuario($user->id());
        return $MensajesUsuario;   
    }



    public function generarMensajes()
    {
        echo '<link rel="stylesheet" type="text/css" href="CSS/bandejaMensajes.css">';  

        if (empty($this->mensajes)) {
            return '<p class="sin-mensajes">No tienes ningún mensaje</p>';
        }
    
        $html = '<div class="bandeja-mensajes">';
    
        $actividadesmensajesAppService = actividadesmensajesAppService::GetSingleton();
        $actividadAppService = actividadAppService::GetSingleton();
    
        foreach ($this->mensajes as $mensajeData) {
            $idActividad = $mensajeData['id_actividad'];
            $mensaje = $mensajeData['mensaje'];
    
            $actividadDTO = $actividadAppService->getActividadById($idActividad);
    
            if ($actividadDTO && $actividadDTO->fecha_hora() > date("Y-m-d H:i:s")) {
                // Se delega la construcción del mensaje a mostrarMensajes()
                $html .= $actividadesmensajesAppService->mostrarMensajes($actividadDTO, $mensaje);
            }
        }
    
        $html .= '</div>';
        return $html;
    }


}
