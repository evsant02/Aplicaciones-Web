<?php
// Se incluyen las dependencias necesarias
require("IActividad.php");
require("actividadDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");

// Excepciones personalizadas
require(__DIR__ . "/../../excepciones/activity/ActivityNotFoundException.php");
require(__DIR__ . "/../../excepciones/activity/DuplicateActivityException.php");
require(__DIR__ . "/../../excepciones/activity/InvalidActivityDataException.php");

class actividadDAO extends baseDAO implements IActividad
{
    public function __construct()
    {
    }

    public function crear($actividadDTO)
    {
        try {
            // Validación básica de datos
            if (empty($actividadDTO->nombre()) || $actividadDTO->aforo() <= 0) {
                throw new InvalidActivityDataException("Datos de actividad no válidos");
            }

            $conn = application::getInstance()->getConexionBd();

            //escape de strings para evitar inyeccion sql
            $escnombre = $this->realEscapeString($actividadDTO->nombre());
            $esclocalizacion = $this->realEscapeString($actividadDTO->localizacion());
            $escfecha_hora = $this->realEscapeString($actividadDTO->fecha_hora());
            $escdescripcion = $this->realEscapeString($actividadDTO->descripcion());

            // Consulta SQL para insertar una nueva actividad
            $query = "INSERT INTO actividades (nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            $nombre = $actividadDTO->nombre();
            $localizacion = $actividadDTO->localizacion();
            $fecha_hora = $actividadDTO->fecha_hora();
            $descripcion = $actividadDTO->descripcion();
            $aforo = $actividadDTO->aforo();
            $dirigida = $actividadDTO->dirigida();
            $ocupacion = $actividadDTO->ocupacion();
            $foto =$actividadDTO->foto();

            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("ssssiiis", $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);

            if ($stmt->execute()) {
                $idActividad = $conn->insert_id;
                return new actividadDTO($idActividad, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 23000) { // Código para duplicados
                throw new DuplicateActivityException("La actividad ya existe");
            }
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
        return false;
    }

    public function eliminar($actividadDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "DELETE FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            $id = $actividadDTO->id();
            $stmt->bind_param("i", $id);

            $resultado=$stmt->execute();

        
            return $resultado;

        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    public function modificar($actividadDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para actualizar los datos de una actividad
            $query = "UPDATE actividades SET nombre = ?, localizacion = ?, fecha_hora = ?, descripcion = ?, aforo = ?, dirigida = ?, ocupacion = ?, foto = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }


            $nombre = $actividadDTO->nombre();
            $localizacion = $actividadDTO->localizacion();
            $fecha_hora = $actividadDTO->fecha_hora();
            $descripcion = $actividadDTO->descripcion();
            $aforo = $actividadDTO->aforo();
            $dirigida = $actividadDTO->dirigida();
            $ocupacion = $actividadDTO->ocupacion();
            $id = $actividadDTO->id();
            $foto = $actividadDTO->foto();

            // Se vinculan los parámetros
            $stmt->bind_param("ssssiiisi", $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $id);

            $resultado=$stmt->execute();

        
            return $resultado;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    public function getActividadById($id)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener una actividad específica
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $id);

            $stmt->execute();

            // Variables para almacenar los resultados
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);

            if ($stmt->fetch()) {
                return new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);
            }
            
            throw new ActivityNotFoundException("Actividad no encontrada");
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }

        return null;
    }

    public function obtenerTodasLasActividades()
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener todas las actividades
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto FROM actividades";
            $stmt = $conn->prepare($query);

            $stmt->execute();
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);

            $actividades = [];
            while ($stmt->fetch()) {
                $actividades[] = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);
            }

            return $actividades;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }
}
?>
