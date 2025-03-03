<?php

require("actividadFactory.php");

class actividadAppService
{
    private static $instance;

    public static function GetSingleton()
    {
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }
  
    private function __construct()
    {
    } 

    public function crear($actividadDTO)
    {
        $IActividadDAO = actividadFactory::CreateActividad();

        $foundedactividadDTO = $IActividadDAO->crear($actividadDTO);

        return $foundedactividadDTO;
    }

    public function eliminar($actividadDTO)
    {
        $IActividadDAO = actividadFactory::CreateActividad();

        $eliminadaactividadDTO = $IActividadDAO->eliminar($actividadDTO);

        return $eliminadaactividadDTO;
    }

    public function modificar($actividadDTO)
    {
        $IActividadDAO = actividadFactory::CreateActividad();

        $modificadaactividadDTO = $IActividadDAO->modificar($actividadDTO);

        return $modificadaactividadDTO;
    }

}

?>