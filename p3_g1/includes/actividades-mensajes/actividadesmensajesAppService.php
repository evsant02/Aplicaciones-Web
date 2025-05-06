<?php

namespace includes\actividadesmensajes;

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

    
}
?>
