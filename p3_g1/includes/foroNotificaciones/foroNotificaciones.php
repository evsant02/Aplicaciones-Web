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

    $actividadAppService = actividadAppService::GetSingleton();
    $user = application::getInstance()->getUserDTO();

    // Invertir el orden para mostrar el más reciente primero
    $mensajesInvertidos = array_reverse($this->mensajes);

    foreach ($mensajesInvertidos as $mensajeData) {
        $idActividad = $mensajeData['id_actividad'];
        $mensaje = $mensajeData['mensaje'];

        $actividadDTO = $actividadAppService->getActividadById($idActividad);

        // Eliminamos la condición de fecha para mostrar todos los mensajes
        if ($actividadDTO) {
            if ($mensaje == 1) {
                $texto = '¡Nueva actividad disponible!';
                $clase = 'mensaje-card mensaje-nueva';
            } elseif ($mensaje == 0) {
                $texto = 'Actividad cancelada';
                $clase = 'mensaje-card mensaje-cancelada';
            } else {
                $texto = 'Mensaje del sistema';
                $clase = 'mensaje-card';
            }

            // **USAMOS .= PARA CONCATENAR TODOS LOS MENSAJES**
            $html .= '<div class="' . $clase . '">';
            $html .= '<div class="mensaje-estado">' . htmlspecialchars($texto) . '</div>';
            $html .= '<div class="actividad-info">';
            $html .= '<h3 class="actividad-titulo">' . htmlspecialchars($actividadDTO->nombre()) . '</h3>';
            $html .= '<span class="actividad-fecha">' . date("d/m/Y H:i", strtotime($actividadDTO->fecha_hora())) . '</span>';
            $html .= '</div>';

            $html .= '<a href="EliminarMensaje.php?id_actividad=' . $idActividad . '&id_usuario=' . $user->id() . '&mensaje=' . $mensaje . '" class="btn-eliminar-link" title="Eliminar mensaje">';
            $html .= '<button type="button" class="btn-eliminar">✖</button>';
            $html .= '</a>';

            $html .= '<a href="' . ($mensaje == 1 ? 'vistaReservaActividad.php?id=' . $idActividad : 'vistaActividades.php') . '" class="btn-eliminar-link" title="' . ($mensaje == 1 ? 'Ir a la actividad' : 'Buscar otra actividad') . '">';
            $html .= '<button type="button" class="btn-act">➜</button>';
            $html .= '</a>';

            $html .= '</div>'; // Cierre de mensaje-card
        }
    }

    $html .= '</div>'; // Cierre de bandeja-mensajes
    return $html;
}


}
