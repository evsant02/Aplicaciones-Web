<?php 

// Se incluyen los archivos necesarios: la base de formularios y el servicio de actividades
include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../actividad/actividadAppService.php";

// Clase que gestiona el formulario de modificación de actividades
class modificarActividadForm extends formBase
{
    private $actividad; // Variable para almacenar la actividad a modificar

    // Constructor: recibe una actividad y la almacena para su edición
    public function __construct($actividad = null) 
    {
        parent::__construct('modificarActividadForm');
        $this->actividad = $actividad; // Guardamos la actividad cargada
    }
    
    // Método que genera el formulario con los datos de la actividad
    protected function CreateFields($datos)
    {
        // Si tenemos una actividad cargada, usamos sus valores; de lo contrario, usamos los datos recibidos en la petición
        $id = $this->actividad ? $this->actividad->id() : ($datos['id'] ?? '');
        $nombre = $this->actividad ? $this->actividad->nombre() : ($datos['nombre'] ?? '');
        $localizacion = $this->actividad ? $this->actividad->localizacion() : ($datos['localizacion'] ?? '');
        $fecha_hora = $this->actividad ? $this->actividad->fecha_hora() : ($datos['fecha_hora'] ?? '');
        $descripcion = $this->actividad ? $this->actividad->descripcion() : ($datos['descripcion'] ?? '');

        // Se genera el formulario con los valores actuales de la actividad
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

    // Método que procesa la modificación de la actividad
    protected function Process($datos)
    {
        $result = array();
        
        // Se extraen y limpian los datos del formulario
        $id = trim($datos['id'] ?? '');
        $nombre = trim($datos['nombre'] ?? '');
        $localizacion = trim($datos['localizacion'] ?? '');
        $fecha_hora = trim($datos['fecha_hora'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');
        $aforo = trim($datos['aforo'] ?? '');

        // Validaciones: se asegura que los campos obligatorios no estén vacíos
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
        if (empty($aforo)) {
            $result[] = "Debe especificar el aforo de la actividad.";
        }
        if (empty($descripcion)) {
            $result[] = "Debe proporcionar una descripción de la actividad.";
        }

        // Si no hay errores, se procede a modificar la actividad en la base de datos
        if (count($result) === 0) {
            try {
                // Crear un nuevo objeto actividadDTO con los valores modificados
                $actividadDTO = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, 0);

                // Obtener la instancia del servicio de actividades
                $actividadAppService = actividadAppService::GetSingleton();

                // Llamar al método que actualiza la actividad en la base de datos
                $actividadAppService->modificar($actividadDTO);

                // Redirigir a la página principal con un mensaje de éxito
                $result = 'EditarActividades.php';

                // Guardar el mensaje en la sesión
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
?>
