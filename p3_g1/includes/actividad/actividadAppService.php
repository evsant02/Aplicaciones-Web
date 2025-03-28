<?php

// Se requiere el archivo que contiene la fábrica de actividades
require("actividadFactory.php");

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
    public function obtenerTodasLasActividades()
    {
        // Se obtiene una instancia del DAO
        $IActividadDAO = actividadFactory::CreateActividad();
        // Se llama al método de consulta
        $actividades = $IActividadDAO->obtenerTodasLasActividades();
        return $actividades;
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
}
?>
