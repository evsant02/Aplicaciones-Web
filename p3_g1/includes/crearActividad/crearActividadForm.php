<?php 

// Se incluyen archivos necesarios: la base para formularios y el servicio de actividades
include __DIR__ . "/../comun/formBase.php";
require_once( __DIR__ . "/../actividad/actividadAppService.php");

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
        $nombre = htmlspecialchars($datos['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
        $localizacion = htmlspecialchars($datos['localizacion'] ?? '', ENT_QUOTES, 'UTF-8');
        $fecha_hora = htmlspecialchars($datos['fecha_hora'] ?? '', ENT_QUOTES, 'UTF-8');
        $descripcion = htmlspecialchars($datos['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
        $aforo = htmlspecialchars($datos['aforo'] ?? '', ENT_QUOTES, 'UTF-8');
        $fechaMinima = date('Y-m-d\TH:i');

        $html = <<<EOF
        <fieldset>
            <legend>Crear Nueva Actividad</legend>
            <p><label>Nombre de la actividad:</label> <input type="text" name="nombre" value="$nombre" required/></p>
            <p><label>Localización:</label> <input type="text" name="localizacion" value="$localizacion" required/></p>
            <p><label>Fecha y hora:</label> <input type="datetime-local" name="fecha_hora" value="$fecha_hora" min="$fechaMinima" required/></p>
            <p><label>Aforo:</label> <input type="number" name="aforo" value="$aforo" required min="1" max="999"/></p>
            <p><label>Descripción detallada:</label> <textarea name="descripcion" required>$descripcion</textarea></p>
            <p><label>Fotografía de la actividad:</label> <input type="file" name="imagen" accept="image/*" required></p>
            <button type="submit" name="crear">Crear</button>
        </fieldset>
EOF;
        return $html;
    }

    // Método que procesa los datos enviados a través del formulario
    protected function Process($datos)
    {
        $result = array();
        
        $nombre = trim($datos['nombre'] ?? '');
        $localizacion = trim($datos['localizacion'] ?? '');
        $fecha_hora = trim($datos['fecha_hora'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');
        $aforo = trim($datos['aforo'] ?? '');

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
        $rutaImagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = basename($_FILES["imagen"]["name"]);
            $rutaDestino = __DIR__ . "/../../img/" . $nombreArchivo;
            $rutaBD = "img/" . $nombreArchivo;
            
            // Validar tipo MIME
            $tipoMime = mime_content_type($_FILES["imagen"]["tmp_name"]);
            $formatosPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
            
            if (!in_array($tipoMime, $formatosPermitidos)) {
                $result[] = "Formato de imagen no válido. Use JPG, PNG, GIF, WEBP o AVIF.";
            } elseif (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
                $result[] = "Error al subir la imagen.";
            } else {
                $rutaImagen = $rutaBD;
            }
        } else {
            $result[] = "Debe subir una imagen válida.";
        }

        // Si no hay errores, se procede a crear la actividad
        if (count($result) === 0) {
            try {
                $actividadDTO = new actividadDTO(0, $nombre, $localizacion, $fecha_hora, $descripcion, (int)$aforo, 0, 0, $rutaImagen);
                $actividadAppService = actividadAppService::GetSingleton();
                $actividadAppService->crear($actividadDTO);

                $result = 'index.php';
                $app = application::getInstance();
                $mensaje = "¡Se ha creado la nueva actividad exitosamente!";
                $app->putAtributoPeticion('mensaje', $mensaje);
            } catch (Exception $e) {
                error_log("Error al crear la actividad: " . $e->getMessage());
                $mensaje= "Se ha producido un error: " . $e->getMessage();
            }
        }

        return $result;
    }
}
