<?php

namespace includes\actividadesmensajes;

use includes\application;

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

    public function mostrarMensajes($actividadDTO, $mensaje){
        $user = application::getInstance()->getUserDTO();
        $app = application::getInstance();

  
        if ($mensaje == 1) {
            $texto = '¡Nueva actividad disponible!';
            $clase = 'mensaje-card mensaje-nueva';
        } elseif ($mensaje == 0) {
            $texto = 'Actividad cancelada.';
            $clase = 'mensaje-card mensaje-cancelada';
        } else {
            $texto = 'Mensaje desconocido.';
            $clase = 'mensaje-card';
        }

        $html = '<div class="' . $clase . '">';
        $html .= '<div class="mensaje-estado">' . htmlspecialchars($texto) . '</div>';
        $html .= '<div class="actividad-info">';
        $html .= '<h3 class="actividad-titulo">' . htmlspecialchars($actividadDTO->titulo()) . '</h3>';
        $html .= '<span class="actividad-fecha">' . date("d/m/Y H:i", strtotime($actividadDTO->fecha_hora())) . '</span>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
            
    }

}
?>
