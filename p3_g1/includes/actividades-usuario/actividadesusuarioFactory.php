<?php

// Se incluye el archivo que contiene la implementación de actividadesusuarioDAO
require("actividadesusuarioDAO.php");

// Definición de la clase actividadesusuarioFactory
class actividadesusuarioFactory
{
    /**
     * Método estático que crea y devuelve una instancia de actividadesusuarioDAO
     * @return IActividadesusuario Una instancia de actividadesusuarioDAO
     */
    public static function CreateActividad() : IActividadesusuario
    {
        // Se crea una nueva instancia de actividadDAO
        $actividadesusuarioDAO = new actividadesusuarioDAO();        
        
        // Se devuelve la instancia creada, cumpliendo con la interfaz IActividad
        return $actividadesusuarioDAO;
    }
}

?>
