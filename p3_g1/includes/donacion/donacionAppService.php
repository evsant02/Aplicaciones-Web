<?php

namespace includes\donacion;

use includes\donacion\donacionFactory;

class donacionAppService
{
    // Variable estática para almacenar una única instancia de la clase (Patrón Singleton)
    private static $instance;

    // Método para obtener la única instancia de userAppService
    public static function GetSingleton()
    {
        // Si la instancia no está creada, se crea una nueva
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance; // Retorna la instancia única
    }

    // Constructor privado para evitar la creación de múltiples instancias
    private function __construct()
    {
    }

    // Método para registrar un nuevo usuario
    public function create($donacionDTO)
    {
        $IDonacionDAO = donacionFactory::CreateDonacion();

        $createdDonacionDTO = $IDonacionDAO->crear($donacionDTO);

        return $createdDonacionDTO;
    }

    // Método para obtener todas las actividades almacenadas en la base de datos
    public function obtenerTodasLasDonaciones()
    {
        // Se obtiene una instancia del DAO
        $IDonacionDAO = donacionFactory::CreateDonacion();
        // Se llama al método de consulta
        $donaciones = $IDonacionDAO->obtenerTodasLasDonaciones();
        return $donaciones;
    }

    public function getEstadisticasDonaciones() {
        $IDonacionDAO = donacionFactory::CreateDonacion();
        
        return $IDonacionDAO->getEstadisticasDonaciones(); // Obtiene estadísticas de las donaciones
    }

}

?>