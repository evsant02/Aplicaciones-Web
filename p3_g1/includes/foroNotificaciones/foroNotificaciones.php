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

        // Invertir el orden del array de mensajes
        $mensajesInvertidos = array_reverse($this->mensajes);

        foreach ($mensajesInvertidos as $mensajeData) {
            $idActividad = $mensajeData->id_actividad();
            $mensaje = $mensajeData->mensaje();
            $user = application::getInstance()->getUserDTO();

            $actividadDTO = $actividadAppService->getActividadById($idActividad);

            if ($actividadDTO && $actividadDTO->fecha_hora() > date("Y-m-d H:i:s")) {
                // $html .= $actividadesmensajesAppService->mostrarMensajes($actividadDTO, $mensaje);
                        
                if ($mensaje == 1) {
                    $texto = '¡Nueva actividad disponible!';
                    $clase = 'mensaje-card mensaje-nueva';
                } elseif ($mensaje == 0) {
                    $texto = 'Actividad cancelada';
                    $clase = 'mensaje-card mensaje-cancelada';
                } else {
                    $texto = 'Mensaje desconocido.';
                    $clase = 'mensaje-card';
                }

                $html = '<div class="' . $clase . '">';
                $html .= '<div class="mensaje-estado">' . htmlspecialchars($texto) . '</div>';
                $html .= '<div class="actividad-info">';
                $html .= '<h3 class="actividad-titulo">' . htmlspecialchars($actividadDTO->nombre()) . '</h3>';
                $html .= '<span class="actividad-fecha">' . date("d/m/Y H:i", strtotime($actividadDTO->fecha_hora())) . '</span>';
                $html .= '</div>';


                $idActividad = intval($actividadDTO->id());
                $idUsuario = $user->id();
                
                $html .= '<a href="EliminarMensaje.php?id_actividad=' . $idActividad . '&id_usuario=' . $idUsuario . '&mensaje=' . $mensaje . '" class="btn-eliminar-link" title="Eliminar mensaje">';
                $html .= '<button type="button" class="btn-eliminar">✖</button>';
                $html .= '</a>';

                if ($mensaje == 1) $html .= '<a href="vistaReservaActividad.php?id=' . $idActividad . '" class="btn-eliminar-link" title="Ir a la actividad">';
                else $html .= '<a href="vistaActividades.php?id= " class="btn-eliminar-link" title="Buscar otra actividad">';
                $html .= '<button type="button" class="btn-act">➜</button>';
                $html .= '</a>';

                $html .= '</div>';
            }
        }

        $html .= '</div>';
        return $html;
    }


}
