<?php

namespace includes\actividadesusuario;

// Se requiere el archivo que contiene la fábrica de actividades
//require_once("actividadesusuarioFactory.php");

// Clase que gestiona el servicio de aplicación para las actividades
class actividadesusuarioAppService
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

    public function getActividadesUsuario($id_usuario)
    {
        $IActividadDAO = actividadesusuarioFactory::CreateActividad();

        $actividad = $IActividadDAO->getActividadesUsuario($id_usuario);

        return $actividad;
    }

    public function isRegistrado($id_usuario, $id_actividad){

        $IActividadesusuarioDAO = actividadesusuarioFactory::CreateActividad();
        $int=$IActividadesusuarioDAO->isRegistrado($id_usuario, $id_actividad);
        return $int;
    }


    public function apuntarUsuario($id_actividad, $id_usuario){
        $IActividadesusuarioDAO = actividadesusuarioFactory::CreateActividad();
        $IActividadesusuarioDAO->apuntarUsuario($id_actividad, $id_usuario);
    }

    public function bajaUsuario($id_actividad, $id_usuario) {
        $IActividadesusuarioDAO = actividadesusuarioFactory::CreateActividad();
        $IActividadesusuarioDAO->bajaUsuario($id_actividad, $id_usuario);
    }

    public function bajaActividad($id_actividad) {
        $IActividadesusuarioDAO = actividadesusuarioFactory::CreateActividad();
        $IActividadesusuarioDAO->bajaActividad($id_actividad);
    }

    //metodo para obtener los usuarios que están inscritos en una actividad (se usa para poder notificarles)
    public function obtenerUsuariosInscritos($id_actividad){
        $IActividadesusuarioDAO = actividadesusuarioFactory::CreateActividad();
        $usuarios = $IActividadesusuarioDAO->obtenerUsuariosInscritos($id_actividad);
        return $usuarios; //devuelve un array de los id_usuario que están apuntados a esa actividad
    }

}
?>
