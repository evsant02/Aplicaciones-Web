<?php 

include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../actividad/actividadAppService.php";

class modificarActividadForm extends formBase
{
    private $actividad;

    public function __construct($actividad = null) 
    {
        parent::__construct('modificarActividadForm');
        $this->actividad = $actividad; // Guardamos la actividad cargada
    }
    
    protected function CreateFields($datos)
    {
        // Si tenemos una actividad cargada, usamos sus métodos para obtener valores; si no, usamos los datos recibidos
        $id = $this->actividad ? $this->actividad->id() : ($datos['id'] ?? '');
        $nombre = $this->actividad ? $this->actividad->nombre() : ($datos['nombre'] ?? '');
        $localizacion = $this->actividad ? $this->actividad->localizacion() : ($datos['localizacion'] ?? '');
        $fecha_hora = $this->actividad ? $this->actividad->fecha_hora() : ($datos['fecha_hora'] ?? '');
        $descripcion = $this->actividad ? $this->actividad->descripcion() : ($datos['descripcion'] ?? '');

        $html = <<<EOF
        <fieldset>
            <legend>Modificar Actividad</legend>
            <input type="hidden" name="id" value="$id" />
            <p><label>Nombre de la actividad:</label> <input type="text" name="nombre" value="$nombre" required/></p>
            <p><label>Localización:</label> <input type="text" name="localizacion" value="$localizacion" required/></p>
            <p><label>Fecha y hora:</label> <input type="datetime-local" name="fecha_hora" value="$fecha_hora" required/></p>
            <p><label>Descripción detallada:</label> <textarea name="descripcion" required>$descripcion</textarea></p>
            <button type="submit" name="modificar">Guardar Cambios</button>
        </fieldset>
EOF;
        return $html;
    }

    protected function Process($datos)
    {
        $result = array();
        
        $id = trim($datos['id'] ?? '');
        $nombre = trim($datos['nombre'] ?? '');
        $localizacion = trim($datos['localizacion'] ?? '');
        $fecha_hora = trim($datos['fecha_hora'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');

        if (empty($id)) {
            $result[] = "ID de actividad no válido.";
        }
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
            try {
                // Crear objeto actividadDTO con los nuevos valores
                $actividadDTO = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion);

                // Obtener instancia del servicio de aplicación
                $actividadAppService = actividadAppService::GetSingleton();

                // Llamar al método para modificar la actividad en la base de datos
                $actividadAppService->modificar($actividadDTO);

                // Redirigir a la página principal con mensaje de éxito
                $result = 'index.php';

                $app = application::getInstance();
                $mensaje = "Se ha modificado la actividad exitosamente!";
                $app->putAtributoPeticion('mensaje', $mensaje);
            } catch (Exception $e) {
                $result[] = "Error al modificar la actividad: " . $e->getMessage();
            }
        }

        return $result;
    }
}
