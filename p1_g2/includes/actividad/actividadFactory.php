<?php

require("actividadDAO.php");

class actividadFactory
{
    public static function CreateActividad() : IActividad
    {
        $actividadDAO = new actividadDAO();        
        
        return $actividadDAO;
    }
}

?>