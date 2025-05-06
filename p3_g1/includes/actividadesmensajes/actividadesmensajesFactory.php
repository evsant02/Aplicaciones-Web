<?php

namespace includes\actividadesmensajes;

// Se incluye el archivo que contiene la implementación de actividadesmensajesDAO
//require_once("actividadesusuarioDAO.php");

// Definición de la clase actividadesmensajesFactory
class actividadesmensajesFactory
{
    /**
     * Método estático que crea y devuelve una instancia de actividadesusuarioDAO
     * @return IActividadesmensajes Una instancia de actividadesmensajesDAO
     */
    public static function CreateActividad() : IActividadesmensajes
    {
        // Se crea una nueva instancia de actividadDAO
        $actividadesmensajesDAO = new actividadesmensajesDAO();        
        
        // Se devuelve la instancia creada, cumpliendo con la interfaz IActividad
        return $actividadesmensajesDAO;
    }
}

?>
