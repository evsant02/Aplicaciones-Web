<?php

require("IActividad.php");
require("actividadDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");

class actividadDAO extends baseDAO implements IActividad
{
    public function __construct()
    {
    }

    public function crear($actividadDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            $query = "INSERT INTO actividades (nombre, localizacion, fecha_hora, descripcion) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            $stmt->bind_param("ssss", 
                $actividadDTO->nombre(), 
                $actividadDTO->localizacion(), 
                $actividadDTO->fecha_hora(), 
                $actividadDTO->descripcion()
            );

            if ($stmt->execute()) {
                $idActividad = $conn->insert_id;
                return new actividadDTO($idActividad, $actividadDTO->nombre(), $actividadDTO->localizacion(), $actividadDTO->fecha_hora(), $actividadDTO->descripcion());
            }
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }

        return false;
    }

    public function eliminar($actividadDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            $query = "DELETE FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            $stmt->bind_param("i", $actividadDTO->id());

            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function modificar($actividadDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            $query = "UPDATE actividades SET nombre = ?, localizacion = ?, fecha_hora = ?, descripcion = ? WHERE id = ?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            $stmt->bind_param("ssssi", 
                $actividadDTO->nombre(), 
                $actividadDTO->localizacion(), 
                $actividadDTO->fecha_hora(), 
                $actividadDTO->descripcion(),
                $actividadDTO->id()
            );

            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function getActividadById($id)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Vincula el parámetro
            $stmt->bind_param("i", $id);

            // Ejecuta la consulta
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }

            $nombre = null;
            $localizacion = null;
            $fecha_hora = null; 
            $descripcion = null;

            // Resultados
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion);

            // Verificar si hay resultados
            if ($stmt->fetch()) {
                return new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion);
            }

        } catch (Exception $e) {
            // Manejo de errores más general
            throw new Exception("Error al obtener la actividad: " . $e->getMessage());
        }

        return null; // No se encontró la actividad
    }


    public function obtenerTodasLasActividades()
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion FROM actividades";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            $stmt->execute();

            $id = null;
            $nombre = null;
            $localizacion = null;
            $fecha_hora = null; 
            $descripcion = null;

            $actividades = [];
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion);

            while ($stmt->fetch()) {
                // Crear un objeto actividadDTO por cada fila
                $actividadDTO = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion);
                $actividades[] = $actividadDTO;
            }

            return $actividades;

        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }


}
?>
