<?php

include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../actividad/actividadAppService.php";


class crearActividadForm extends formBase
{
    public function __construct() 
    {
        parent::__construct('crearActividadForm');
    }
    
    protected function CreateFields($datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $localizacion = $datos['localizacion'] ?? '';
        $fecha_hora = $datos['fecha_hora'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';

        $html = <<<EOF
        <fieldset>
            <legend>Crear Nueva Actividad</legend>
            <p><label>Nombre de la actividad:</label> <input type="text" name="nombre" value="$nombre" required/></p>
            <p><label>Localización:</label> <input type="text" name="localizacion" value="$localizacion" required/></p>
            <p><label>Fecha y hora:</label> <input type="datetime-local" name="fecha_hora" value="$fecha_hora" required/></p>
            <p><label>Descripción detallada:</label> <textarea name="descripcion" required>$descripcion</textarea></p>
            <button type="submit" name="crear">Crear</button>
        </fieldset>
EOF;
        return $html;
    }

    protected function Process($datos)
    {
        $result = array();
        
        $nombre = trim($datos['nombre'] ?? '');
        $localizacion = trim($datos['localizacion'] ?? '');
        $fecha_hora = trim($datos['fecha_hora'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');

        if (empty($nombre)) {
            $result[] = "El nombre de la actividad no puede estar vacío.";
        }
        if (empty($localizacion)) {
            $result[] = "La localización no puede estar vacía.";
        }
        if (empty($fecha_hora)) {
            $result[] = "Debe especificar la fecha y hora de la actividad.";
        }
        if (empty($descripcion)) {
            $result[] = "Debe proporcionar una descripción de la actividad.";
        }

        if (count($result) === 0) {
            // Aquí iría la lógica para almacenar la actividad en la base de datos
            // Por ejemplo: 
            // $actividadDTO = new actividadDTO(0, $nombre, $localizacion, $fecha_hora, $descripcion);
            // $actividadAppService = actividadAppService::GetSingleton();
            // $actividadAppService->crear($actividadDTO);

            $result = 'index.php'; // Redirecciona a la página principal

            $app = application::getInstance();
                
            $mensaje = "Se ha creado la nueva actividad exitosamente";
            
            $app->putAtributoPeticion('mensaje', $mensaje);
        }

        return $result;
    }
}
