<?php

namespace includes\actividadesmensajes;

use includes\application;
use includes\usuario\userAppService;

// Se requiere el archivo que contiene la fábrica de actividades
//require_once("actividadesusuarioFactory.php");

// Clase que gestiona el servicio de aplicación para las actividades
class actividadesmensajesAppService
{
    // Propiedad estática para almacenar la única instancia del servicio (Singleton)
    private static $instance;

    // Método que devuelve la única instancia de la clase (patrón Singleton)
    public static function GetSingleton()
    {
        // Si no existe una instancia, se crea una nueva
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

    // Constructor privado para evitar la creación de múltiples instancias
    private function __construct()
    {
    } 
    

    public function getMensajesPorUsuario($id_usuario)
    {
        $IActividadDAO = actividadesmensajesFactory::CreateActividad();

        $actividad = $IActividadDAO->getMensajesPorUsuario($id_usuario);

        return $actividad;
    }

    public function eliminarMensaje($idUsuario, $idActividad){

        $IActividadDAO = actividadesmensajesFactory::CreateActividad();

        $IActividadDAO->eliminarMensaje($idUsuario,$idActividad);

    }

    

    public function mostrarMensajes($actividadDTO, $mensaje){
        $user = application::getInstance()->getUserDTO();
  
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
        $idUsuario = intval($user->id());
        
        $html .= '<a href="EliminarMensaje.php?id_actividad=' . $idActividad . '&id_usuario=' . $idUsuario . '" class="btn-eliminar-link" title="Eliminar mensaje">';
        $html .= '<button type="button" class="btn-eliminar">✖</button>';
        $html .= '</a>';

        if ($mensaje == 1) $html .= '<a href="vistaReservaActividad.php?id=' . $idActividad . '" class="btn-eliminar-link" title="Ir a la actividad">';
        else $html .= '<a href="vistaActividades.php?id= " class="btn-eliminar-link" title="Buscar otra actividad">';
        $html .= '<button type="button" class="btn-act">➜</button>';
        $html .= '</a>';

        $html .= '</div>';


        return $html;
            
    }

    public function crearMensaje($mensajeDTO){
        
        $IActividadDAO = actividadesmensajesFactory::CreateActividad();
        $createdMensaje = $IActividadDAO->crearMensaje($mensajeDTO);
        return $createdMensaje;

    }

    //metodo que va a notificar a todos los usuarios de la plataforma indicando que hay una nueva actividad disponible (un usuario se a apuntado a dirigirla)
    public function notificarActividadDisponibleATodos($id_actividad){
        //obtengo todos los usuarios
        $usuarioAppService = userAppService::GetSingleton();
        $usuarios = $usuarioAppService->getTodosLosUsuarios(); //metodo que me devuelve todos los id_usuario para poder mandarles la notificacion
    
        foreach ($usuarios as $id_usuario) {
            $dto = new actividadesmensajesDTO($id_actividad, $id_usuario, 1);
            $this->crearMensaje($dto); // tipo 1 = actividad disponible
        }

    }


    

}
?>
