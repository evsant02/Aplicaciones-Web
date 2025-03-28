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

            // Consulta SQL para insertar una nueva actividad
            $query = "INSERT INTO actividades (nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            $nombre = $actividadDTO->nombre();
            $localizacion = $actividadDTO->localizacion();
            $fecha_hora = $actividadDTO->fecha_hora();
            $descripcion = $actividadDTO->descripcion();
            $aforo = $actividadDTO->aforo();
            $dirigida = $actividadDTO->dirigida();
            $ocupacion = $actividadDTO->ocupacion();

            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("ssssiii", $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion);

            if ($stmt->execute()) {
                $idActividad = $conn->insert_id;
                return new actividadDTO($idActividad, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion);
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
            $query = "UPDATE actividades SET nombre = ?, localizacion = ?, fecha_hora = ?, descripcion = ?, aforo = ?, dirigida = ?, ocupacion = ? WHERE id = ?";
            $stmt = $conn->prepare($query);


            $nombre = $actividadDTO->nombre();
            $localizacion = $actividadDTO->localizacion();
            $fecha_hora = $actividadDTO->fecha_hora();
            $descripcion = $actividadDTO->descripcion();
            $aforo = $actividadDTO->aforo();
            $dirigida = $actividadDTO->dirigida();
            $ocupacion = $actividadDTO->ocupacion();
            $id = $actividadDTO->id();

            // Se vinculan los parámetros
            $stmt->bind_param("ssssiiii", $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $id);

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
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $id);

            $stmt->execute();

            // Variables para almacenar los resultados
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion);

            if ($stmt->fetch()) {
                return new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion);
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
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion FROM actividades";
            $stmt = $conn->prepare($query);

            $stmt->execute();
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion);

            $actividades = [];
            while ($stmt->fetch()) {
                $actividades[] = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion);
            }

            return $actividades;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }


    //Método para obtener actividades que todavia no están dirigidas por un usuario
    public function obtenerActSinDirigir(){
        try{
            $conn = application::getInstance()->getConexionBd();

            $query= "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida FROM actividades WHERE dirigida = 0";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Se ejecuta la consulta
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


    public function obtenerActSinCompletar(){
        try{
            $conn = application::getInstance()->getConexionBd();

            $query= "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion FROM actividades WHERE dirigida = 1 AND aforo - ocupacion > 0";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Se ejecuta la consulta
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
?>
