<?php

require("IActividad.php");
require("actividadDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");
//require("actividadAlreadyExistException.php");

class actividadDAO extends baseDAO implements IActividad
{
    public function __construct()
    {

    }

    public function crear($actividadDTO)
    {

    }

    public function eliminar($actividadDTO)
    {
        
    }

    public function modificar($actividadDTO)
    {
        
    }
            
}
?>