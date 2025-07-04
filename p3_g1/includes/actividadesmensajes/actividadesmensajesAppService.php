<?php

namespace includes\actividadesmensajes;

use includes\application;
use includes\usuario\userAppService;
use includes\actividadesusuario\actividadesusuarioAppService;

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

    public function eliminarMensaje($idUsuario, $idActividad, $idMensaje){

        $IActividadDAO = actividadesmensajesFactory::CreateActividad();

        $IActividadDAO->eliminarMensaje($idUsuario,$idActividad, $idMensaje);

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

    public function notificarBajaVoluntario($id_actividad){
        //primero obtengo los usuarios de esa actividad antes de darles de baja
        $actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();
        $usuariosApuntados = $actividadUsuarioAppService->obtenerUsuariosInscritos($id_actividad); //me devuelve los usuarios de una actividad

        //envio mensajes a esos usuarios
        $mensajesAppService = actividadesmensajesAppService::GetSingleton();
        foreach ($usuariosApuntados as $idUsuario) {
            $dto = new actividadesmensajesDTO($id_actividad, $idUsuario, 0);// 0 = tipo de mensaje de que un voluntario se ha dado de baja
            $mensajesAppService->crearMensaje($dto); 
        }
    }

    public function tieneMensajesNuevos($id_usuario) {
        $IActividadDAO = actividadesmensajesFactory::CreateActividad();
        $mensajes = $IActividadDAO->tieneMensajes($id_usuario);
        return $mensajes;
    }
}

?>
