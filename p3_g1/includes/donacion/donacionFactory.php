<?php

namespace includes\donacion;

// Definición de la clase actividadFactory
class donacionFactory
{
    /**
     * Método estático que crea y devuelve una instancia de actividadDAO
     * @return IDonacion Una instancia de actividadDAO
     */
    public static function CreateDonacion() : IDonacion
    {
        // Se crea una nueva instancia de actividadDAO
        $donacionDAO = new donacionDAO();        
        
        // Se devuelve la instancia creada, cumpliendo con la interfaz IActividad
        return $donacionDAO;
    }
}

?>
