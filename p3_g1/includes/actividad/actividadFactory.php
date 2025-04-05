<?php

// Se incluye el archivo que contiene la implementación de actividadDAO
require_once("actividadDAO.php");

// Definición de la clase actividadFactory
class actividadFactory
{
    /**
     * Método estático que crea y devuelve una instancia de actividadDAO
     * @return IActividad Una instancia de actividadDAO
     */
    public static function CreateActividad() : IActividad
    {
        // Se crea una nueva instancia de actividadDAO
        $actividadDAO = new actividadDAO();        
        
        // Se devuelve la instancia creada, cumpliendo con la interfaz IActividad
        return $actividadDAO;
    }
}

?>
