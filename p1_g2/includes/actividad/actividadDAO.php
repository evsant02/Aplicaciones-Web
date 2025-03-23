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

            //escape de strings para evitar inyeccion sql
            $escnombre = $this->realEscapeString($actividadDTO->nombre());
            $esclocalizacion = $this->realEscapeString($actividadDTO->localizacion());
            $escfecha_hora = $this->realEscapeString($actividadDTO->fecha_hora());
            $escdescripcion = $this->realEscapeString($actividadDTO->descripcion());

            // Consulta SQL para insertar una nueva actividad
            $query = "INSERT INTO actividades (nombre, localizacion, fecha_hora, descripcion) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("ssss", 
                $escnombre, 
                $esclocalizacion, 
                $escfecha_hora, 
                $escdescripcion
            );

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el ID generado por la inserción
                $idActividad = $conn->insert_id;
                return new actividadDTO($idActividad, $actividadDTO->nombre(), $actividadDTO->localizacion(), $actividadDTO->fecha_hora(), $actividadDTO->descripcion());
            }
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
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

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Se vincula el parámetro ID y se escapa el string
            $escid = $this -> realEscapeString($actividadDTO ->id());
            $stmt->bind_param("i", $escid);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    // Método para modificar una actividad existente
    public function modificar($actividadDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para actualizar los datos de una actividad
            $query = "UPDATE actividades SET nombre = ?, localizacion = ?, fecha_hora = ?, descripcion = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            //escape de strings para evitar inyecciones de SQL
            $escnombre = $this->realEscapeString($actividadDTO->nombre());
            $esclocalizacion = $this->realEscapeString($actividadDTO->localizacion());
            $escfecha_hora = $this->realEscapeString($actividadDTO->fecha_hora());
            $escdescripcion = $this->realEscapeString($actividadDTO->descripcion());
            $escid = $this -> realEscapeString($actividadDTO ->id());

            // Se vinculan los parámetros
            $stmt->bind_param("ssssi", 
                $escnombre, 
                $esclocalizacion, 
                $escfecha_hora, 
                $escdescripcion,
                $escid
            );

            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
        
    }

    // Método para obtener una actividad por su ID
    public function getActividadById($id)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener una actividad específica
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            $escid = $this->realEscapeString($id);
            // Se vincula el parámetro ID
            $stmt->bind_param("i", $escid);

            // Se ejecuta la consulta
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }

            // Variables para almacenar los resultados
            $nombre = null;
            $localizacion = null;
            $fecha_hora = null; 
            $descripcion = null;

            // Se vinculan los resultados
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion);

            // Si se encuentra la actividad, se devuelve un objeto actividadDTO
            if ($stmt->fetch()) {
                return new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion);
            }

        } catch (Exception $e) {
            // Manejo de errores general
            throw new Exception("Error al obtener la actividad: " . $e->getMessage());
        }

        return null; // No se encontró la actividad
    }

    // Método para obtener todas las actividades almacenadas en la base de datos
    public function obtenerTodasLasActividades()
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener todas las actividades
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion FROM actividades";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Se ejecuta la consulta
            $stmt->execute();

            // Variables para almacenar los resultados
            $id = null;
            $nombre = null;
            $localizacion = null;
            $fecha_hora = null; 
            $descripcion = null;

            $actividades = [];
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion);

            // Se recorren los resultados y se almacenan en un array de objetos actividadDTO
            while ($stmt->fetch()) {
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
