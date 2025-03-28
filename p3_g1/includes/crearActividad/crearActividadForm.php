<?php 

// Se incluyen archivos necesarios: la base para formularios y el servicio de actividades
include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../actividad/actividadAppService.php";

// Clase que gestiona el formulario de creación de actividades
class crearActividadForm extends formBase
{
    // Constructor: inicializa el formulario con un identificador único
    public function __construct() 
    {
        parent::__construct('crearActividadForm');
    }
    
    // Método que genera los campos del formulario
    protected function CreateFields($datos)
    {
        // Se obtienen los datos previos (si existen) o se dejan vacíos por defecto
        // Se usa htmlspecialchars para evitar ataques XSS al imprimir valores en el formulario
        $nombre = htmlspecialchars($datos['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
        $localizacion = htmlspecialchars($datos['localizacion'] ?? '', ENT_QUOTES, 'UTF-8');
        $fecha_hora = htmlspecialchars($datos['fecha_hora'] ?? '', ENT_QUOTES, 'UTF-8');
        $descripcion = htmlspecialchars($datos['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
        $aforo = htmlspecialchars($datos['aforo'] ?? '', ENT_QUOTES, 'UTF-8');

        // Se genera el formulario en HTML con los valores recuperados
        $html = <<<EOF
        <fieldset>
            <legend>Crear Nueva Actividad</legend>
            <p><label>Nombre de la actividad:</label> <input type="text" name="nombre" value="$nombre" required/></p>
            <p><label>Localización:</label> <input type="text" name="localizacion" value="$localizacion" required/></p>
            <p><label>Fecha y hora:</label> <input type="datetime-local" name="fecha_hora" value="$fecha_hora" required/></p>
            <p><label>Aforo:</label> <input type="number" name="aforo" value="$aforo" required min="1"/></p>
            <p><label>Descripción detallada:</label> <textarea name="descripcion" required>$descripcion</textarea></p>
            <button type="submit" name="crear">Crear</button>
        </fieldset>
EOF;
        return $html;
    }

    // Método que procesa los datos enviados a través del formulario
    protected function Process($datos)
    {
        $result = array();
        
        // Se recuperan y limpian los datos enviados por el usuario
        $nombre = trim($datos['nombre'] ?? '');
        $localizacion = trim($datos['localizacion'] ?? '');
        $fecha_hora = trim($datos['fecha_hora'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');
        $aforo = trim($datos['aforo'] ?? '');

        // Validaciones: se verifica que todos los campos estén completos
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
            $result[] = "Debe proporcionar el aforo de la actividad.";
        }
        // Se verifica que el aforo sea un número entero positivo
        if (!ctype_digit($aforo) || (int)$aforo <= 0) {
            $result[] = "El aforo debe ser un número entero positivo.";
        }
        if (empty($descripcion)) {
            $result[] = "Debe proporcionar una descripción de la actividad.";
        }

        // Si no hay errores, se procede a crear la actividad
        if (count($result) === 0) {
            try {
                // Se crea un objeto de actividad con los datos ingresados
                $actividadDTO = new actividadDTO(0, $nombre, $localizacion, $fecha_hora, $descripcion, (int)$aforo, 0, 0);

                // Se obtiene la instancia del servicio de actividades
                $actividadAppService = actividadAppService::GetSingleton();

                // Se almacena la nueva actividad en la base de datos
                $actividadAppService->crear($actividadDTO);

                // Se redirige a la página principal con un mensaje de éxito
                $result = 'index.php';

                // Se almacena un mensaje de éxito en la sesión para mostrarlo al usuario
                $app = application::getInstance();
                $mensaje = "Se ha creado la nueva actividad exitosamente";
                $app->putAtributoPeticion('mensaje', $mensaje);

            } catch (Exception $e) {
                // Si ocurre un error, se almacena el mensaje de error y se registra en un log
                error_log("Error al crear la actividad: " . $e->getMessage());
                $result[] = "Error al crear la actividad: " . $e->getMessage();
            }
        }

        return $result;
    }
}
