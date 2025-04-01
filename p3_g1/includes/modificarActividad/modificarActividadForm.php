<?php 

// Se incluyen los archivos necesarios: la base de formularios y el servicio de actividades
include __DIR__ . "/../comun/formBase.php";
require_once( __DIR__ . "/../actividad/actividadAppService.php");

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
    
    protected function CreateFields($datos)
    {
        // Si tenemos una actividad cargada, usamos sus valores; de lo contrario, usamos los datos recibidos en la petición
        $id = $this->actividad ? $this->actividad->id() : ($datos['id'] ?? '');
        $nombre = $this->actividad ? $this->actividad->nombre() : ($datos['nombre'] ?? '');
        $localizacion = $this->actividad ? $this->actividad->localizacion() : ($datos['localizacion'] ?? '');
        $fecha_hora = $this->actividad ? date('Y-m-d\TH:i', strtotime($this->actividad->fecha_hora())) : ($datos['fecha_hora'] ?? '');
        $descripcion = $this->actividad ? $this->actividad->descripcion() : ($datos['descripcion'] ?? '');
        $aforo = $this->actividad ? $this->actividad->aforo() : ($datos['aforo'] ?? '');
        $dirigida = $this->actividad ? $this->actividad->dirigida() : ($datos['dirigida'] ?? '');
        $ocupacion = $this->actividad ? $this->actividad->ocupacion() : ($datos['ocupacion'] ?? '');
        $imagen = $this->actividad ? $this->actividad->foto() : null; // Obtener la imagen actual si existe

        $fechaMinima = date('Y-m-d\TH:i');

        // Generar el formulario
        $html = <<<EOF
        <fieldset>
            <legend>Modificar Actividad</legend>
            <input type="hidden" name="id" value="$id" />
            <p><label>Nombre de la actividad:</label> <input type="text" name="nombre" value="$nombre" required/></p>
            <p><label>Localización:</label> <input type="text" name="localizacion" value="$localizacion" required/></p>
            <p><label>Fecha y hora:</label> <input type="datetime-local" name="fecha_hora" value="$fecha_hora" min="$fechaMinima" required/></p>
            <p><label>Aforo:</label> <input type="number" name="aforo" value="$aforo" required min="1" max="999"/></p>
            <p><label>Descripción detallada:</label> <textarea name="descripcion" required>$descripcion</textarea></p>
            <input type="hidden" name="dirigida" value="$dirigida" />
            <input type="hidden" name="ocupacion" value="$ocupacion" />

            <!-- Mostrar imagen actual si existe -->
            <p><label>Imagen actual:</label></p>
            <p>
                <?php if ($imagen): ?>
                    <img src="$imagen" alt="Imagen de la actividad" width="500" />
                <?php endif; ?>
            </p>

            <!-- Campo para subir nueva imagen -->
            <p><label>Subir nueva imagen:</label> <input type="file" name="imagen" accept="image/*" /></p>
            
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
        $dirigida = trim($datos['dirigida'] ?? '');
        $ocupacion = trim($datos['ocupacion'] ?? '');

        // Validaciones
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
        } elseif (strtotime($fecha_hora) < time()) {
            $result[] = "La fecha y hora no puede ser anterior o igual a la actual.";
        }
        if (empty($aforo)) {
            $result[] = "Debe proporcionar el aforo de la actividad.";
        }
        if (empty($descripcion)) {
            $result[] = "Debe proporcionar una descripción de la actividad.";
        }

        // Manejo de la imagen
        $rutaImagen = $this->actividad ? $this->actividad->foto() : null; // Usar la imagen actual si no se selecciona una nueva

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = basename($_FILES["imagen"]["name"]);
            $rutaDestino = __DIR__ . "/../../img/" . $nombreArchivo;
            $rutaBD = "img/" . $nombreArchivo;
            
            // Validar tipo MIME
            $tipoMime = mime_content_type($_FILES["imagen"]["tmp_name"]);
            $formatosPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
            
            if (!in_array($tipoMime, $formatosPermitidos)) {
                $result[] = "Formato de imagen no válido. Use JPG, PNG o GIF.";
            } elseif (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
                $result[] = "Error al subir la imagen.";
            } else {
                $rutaImagen = $rutaBD; // Usar la nueva imagen
            }
        }

        // Si no hay errores, se procede a modificar la actividad
        if (count($result) === 0) {
            try {
                // Crear un nuevo objeto actividadDTO con los valores modificados
                $actividadDTO = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $rutaImagen);

                // Obtener la instancia del servicio de actividades
                $actividadAppService = actividadAppService::GetSingleton();

                // Llamar al método que actualiza la actividad en la base de datos
                $actividadAppService->modificar($actividadDTO);

                // Redirigir a la página principal con un mensaje de éxito
                $result = 'vistaActividades.php';

                // Guardar el mensaje en la sesión
                $app = application::getInstance();
                $mensaje = "¡Se ha modificado la actividad exitosamente!";
                $app->putAtributoPeticion('mensaje', $mensaje);
            } catch (Exception $e) {
                $result[] = "Error al modificar la actividad: " . $e->getMessage();
            }
        }

        return $result;
    }
}
?>
