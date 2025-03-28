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
            $query = "INSERT INTO actividades (nombre, localizacion, fecha_hora, descripcion, aforo, dirigida) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            $nombre = $actividadDTO->nombre();
            $localizacion = $actividadDTO->localizacion();
            $fecha_hora = $actividadDTO->fecha_hora();
            $descripcion = $actividadDTO->descripcion();
            $aforo = $actividadDTO->aforo();
            $dirigida = $actividadDTO->dirigida();

            $stmt->bind_param("ssssii", $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida);

            if ($stmt->execute()) {
                $idActividad = $conn->insert_id;
                return new actividadDTO($idActividad, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida);
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
            $query = "UPDATE actividades SET nombre = ?, localizacion = ?, fecha_hora = ?, descripcion = ?, aforo = ?, dirigida = ? WHERE id = ?";
            $stmt = $conn->prepare($query);


            $nombre = $actividadDTO->nombre();
            $localizacion = $actividadDTO->localizacion();
            $fecha_hora = $actividadDTO->fecha_hora();
            $descripcion = $actividadDTO->descripcion();
            $aforo = $actividadDTO->aforo();
            $dirigida = $actividadDTO->dirigida();
            $id = $actividadDTO->id();

            $stmt->bind_param("ssssiii", $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $id);

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
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $id);

            $stmt->execute();

            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida);

            if ($stmt->fetch()) {
                return new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida);
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
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida FROM actividades";
            $stmt = $conn->prepare($query);

            $stmt->execute();

            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida);

            $actividades = [];
            while ($stmt->fetch()) {
                $actividades[] = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida);
            }

            return $actividades;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }
}