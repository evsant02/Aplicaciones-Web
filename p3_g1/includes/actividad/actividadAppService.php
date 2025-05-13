<?php

namespace includes\actividad;

require_once(__DIR__ . "/../config.php");

use includes\application;

// Clase que gestiona el servicio de aplicación para las actividades
class actividadAppService
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

    // Método para crear una nueva actividad en la base de datos
    public function crear($actividadDTO)
    {
        // Se obtiene una instancia del DAO a través de la fábrica
        $IActividadDAO = actividadFactory::CreateActividad();
        // Se llama al método correspondiente para crear la actividad
        $foundedactividadDTO = $IActividadDAO->crear($actividadDTO);
        return $foundedactividadDTO;
    }

    // Método para eliminar una actividad existente por ID
    public function eliminarPorId($id)
    {
        // Se obtiene una instancia del DAO
        $IActividadDAO = actividadFactory::CreateActividad();
        
        // Buscar la actividad por ID
        $actividad = $IActividadDAO->getActividadById($id);
        
        // Si la actividad no existe, retornar falso
        if ($actividad === null) {
            return false;
        }

        // Llamar al método de eliminación del DAO
        $eliminada = $IActividadDAO->eliminar($actividad);

        // Retornar el resultado de la eliminación (true si fue exitosa, false si no)
        return $eliminada;
    }

    // Método para modificar una actividad existente
    public function modificar($actividadDTO)
    {
        // Se obtiene una instancia del DAO
        $IActividadDAO = actividadFactory::CreateActividad();
        // Se llama al método de modificación
        $modificadaactividadDTO = $IActividadDAO->modificar($actividadDTO);
        return $modificadaactividadDTO;
    }

    // Método para obtener todas las actividades almacenadas en la base de datos
    public function obtenerTodasLasActividades($limit, $offset)
    {
        // Se obtiene una instancia del DAO
        $IActividadDAO = actividadFactory::CreateActividad();
        // Se llama al método de consulta
        return $IActividadDAO->obtenerTodasLasActividades($limit, $offset);
    }

    //Método par obtener las actividades segun el tipo de usuario
    public function obtenerActividadSegunUsuario($limit, $offset): array
    {
        //si es admin, se muestran todas las actividades
        if (application::getInstance()->soyAdmin()){            
            return $this->obtenerTodasLasActividades($limit, $offset);
        }

        //si es voluntario, se muestran solo aquellas que no están dirigidas
        else if (application::getInstance()->soyVoluntario()){            
            // Se obtiene una instancia del DAO
            $IActividadDAO = actividadFactory::CreateActividad();
            // Se llama al método de consulta
            return $IActividadDAO->obtenerActSinDirigir($limit, $offset);
        }

        //si es usuario, solo se muestran las que ya tienen un voluntario asignado y no tienen el aforo al maximo
        else {
            // Se obtiene una instancia del DAO
            $IActividadDAO = actividadFactory::CreateActividad();
            // Se llama al método de consulta
            return $IActividadDAO->obtenerActSinCompletar($limit, $offset);
        }

    }

    
    // Método para obtener una actividad específica por su ID
    public function getActividadById($id)
    {
        // Se obtiene una instancia del DAO
        $IActividadDAO = actividadFactory::CreateActividad();
        // Se llama al método que busca la actividad por su ID
        $actividad = $IActividadDAO->getActividadById($id);
        return $actividad;
    }


    public function annadirusuario($id_actividad){
        $IActividadDAO = actividadFactory::CreateActividad();
        $IActividadDAO->annadirusuario($id_actividad);
    }


    public function annadirVoluntario($id_actividad){
        $IActividadDAO = actividadFactory::CreateActividad();
        $IActividadDAO->annadirVoluntario($id_actividad);
    }


    public function borrarUsuario($id_actividad) {
        $IActividadDAO = actividadFactory::CreateActividad();
        $IActividadDAO->borrarUsuario($id_actividad);
    }

    
    public function borrarVoluntario($id_actividad) {
        $IActividadDAO = actividadFactory::CreateActividad();
        $IActividadDAO->borrarVoluntario($id_actividad);
    }

    public function nombreVoluntario($id_actividad){
        $IActividadDAO = actividadFactory::CreateActividad();
        $actividadDTO=$IActividadDAO->nombreVoluntario($id_actividad);
        return $actividadDTO;
    }

    public function estaDirigida($id_actividad){
        $IActividadDAO = actividadFactory::CreateActividad();
        return $IActividadDAO->estaDirigida($id_actividad);
    }
    public function actividadesFiltrar($desde, $hasta, $texto, $tipos, $usuario){
        $IActividadDAO = actividadFactory::CreateActividad();
        $actividades = $IActividadDAO->actividadesFiltrar($desde, $hasta, $texto, $tipos, $usuario);
        return $actividades;
    }
}
?>
