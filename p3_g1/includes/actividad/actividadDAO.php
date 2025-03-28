<?php
// Se incluyen las dependencias necesarias
require("IActividad.php");
require("actividadDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");

// Clase que implementa el acceso a la base de datos para la gestión de actividades
class actividadDAO extends baseDAO implements IActividad
{
    // Constructor vacío
    public function __construct()
    {
    }

    // Método para crear una nueva actividad en la base de datos
    public function crear($actividadDTO)
    {
        try {
            // Obtener conexión con la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para insertar una nueva actividad
            $query = "INSERT INTO actividades (nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            // Se extraen los valores del DTO en variables antes de pasarlos a bind_param()
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

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el ID generado por la inserción
                $idActividad = $conn->insert_id;
                return new actividadDTO($idActividad, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);
            }
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close(); // Asegura que el statement se cierra siempre
            }
        }
        return false;
    }

    // Método para eliminar una actividad existente
    public function eliminar($actividadDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para eliminar una actividad por su ID
            $query = "DELETE FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            $id = $actividadDTO->id();
            // Se vincula el parámetro ID
            $stmt->bind_param("i", $id);
            $resultado = $stmt->execute();
            return $resultado;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    // Método para modificar una actividad existente
    public function modificar($actividadDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para actualizar los datos de una actividad
            $query = "UPDATE actividades SET nombre = ?, localizacion = ?, fecha_hora = ?, descripcion = ?, aforo = ?, dirigida = ?, ocupacion = ?, foto = ? WHERE id = ?";
            $stmt = $conn->prepare($query);

            // Se extraen los valores en variables antes de pasarlos a bind_param()
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

            $resultado = $stmt->execute();
            return $resultado;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    // Método para obtener una actividad por su ID
    public function getActividadById($id)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener una actividad específica
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            // Se vincula el parámetro ID
            $stmt->bind_param("i", $id);

            // Se ejecuta la consulta
            $stmt->execute();

            // Variables para almacenar los resultados
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);

            // Si se encuentra la actividad, se devuelve un objeto actividadDTO
            if ($stmt->fetch()) {
                return new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);
            }
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
        return null; // No se encontró la actividad
    }

    // Método para obtener todas las actividades almacenadas en la base de datos
    public function obtenerTodasLasActividades()
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener todas las actividades
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto FROM actividades";
            $stmt = $conn->prepare($query);

            // Se ejecuta la consulta
            $stmt->execute();
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);

            $actividades = [];
            while ($stmt->fetch()) {
                $actividades[] = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);
            }

            return $actividades;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }
}
?>
