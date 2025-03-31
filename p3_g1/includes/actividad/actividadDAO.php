<?php
// Se incluyen las dependencias necesarias
require("IActividad.php");
require("actividadDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");

// Excepciones personalizadas
require(__DIR__ . "/../../excepciones/activity/ActivityNotFoundException.php");
require(__DIR__ . "/../../excepciones/activity/DuplicateActivityException.php");
require(__DIR__ . "/../../excepciones/activity/InvalidActivityDataException.php");

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
            // Validación básica de datos
            if (empty($actividadDTO->nombre()) || $actividadDTO->aforo() <= 0) {
                throw new InvalidActivityDataException("Datos de actividad no válidos");
            }

            // Obtener conexión con la base de datos
            $conn = application::getInstance()->getConexionBd();

            //escape de strings para evitar inyeccion sql
            $escnombre = $this->realEscapeString($actividadDTO->nombre());
            $esclocalizacion = $this->realEscapeString($actividadDTO->localizacion());
            $escfecha_hora = $this->realEscapeString($actividadDTO->fecha_hora());
            $escdescripcion = $this->realEscapeString($actividadDTO->descripcion());
            $escaforo = $this->realEscapeString($actividadDTO->aforo());
            $escdirigida = $this->realEscapeString($actividadDTO->dirigida());
            $escocupacion = $this->realEscapeString($actividadDTO->ocupacion());
            $escfoto = $this->realEscapeString($actividadDTO->foto());

            // Consulta SQL para insertar una nueva actividad
            $query = "INSERT INTO actividades (nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("ssssiiis", 
                $escnombre, 
                $esclocalizacion, 
                $escfecha_hora, 
                $escdescripcion,
                $escaforo,
                $escdirigida,
                $escocupacion,
                $escfoto
            );

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el ID generado por la inserción
                $idActividad = $conn->insert_id;
                return new actividadDTO($idActividad, $escnombre, $esclocalizacion, $escfecha_hora, $escdescripcion, $escaforo, $escdirigida, $escocupacion, $escfoto);
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 23000) { // Código para duplicados
                throw new DuplicateActivityException("La actividad ya existe");
            }
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

            // Se vincula el parámetro ID
            $escid = $this->realEscapeString($actividadDTO ->id());
            $stmt->bind_param("i", $escid);
            $resultado = $stmt->execute();

            return $resultado;

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

           //escape de strings para evitar inyecciones de SQL
           $escnombre = $this->realEscapeString($actividadDTO->nombre());
           $esclocalizacion = $this->realEscapeString($actividadDTO->localizacion());
           $escfecha_hora = $this->realEscapeString($actividadDTO->fecha_hora());
           $escdescripcion = $this->realEscapeString($actividadDTO->descripcion());
           $escid = $this -> realEscapeString($actividadDTO ->id());
           $escaforo = $this->realEscapeString($actividadDTO->aforo());
           $escfoto = $this->realEscapeString($actividadDTO->foto());
           $escdirigida = $this->realEscapeString($actividadDTO->dirigida());
           $escocupacion = $this->realEscapeString($actividadDTO->ocupacion());

           // Se vinculan los parámetros
           $stmt->bind_param("ssssiisii", 
               $escnombre, 
               $esclocalizacion, 
               $escfecha_hora, 
               $escdescripcion,
               $escid,
               $escaforo,
               $escfoto,
               $escdirigida,
               $escocupacion
           );

            $resultado = $stmt->execute();

            return $resultado;
        
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

            throw new ActivityNotFoundException("Actividad no encontrada");

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

            $query= "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto FROM actividades WHERE dirigida = 0";
            $stmt = $conn->prepare($query);

            // Se ejecuta la consulta
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


    public function obtenerActSinCompletar(){
        try{
            $conn = application::getInstance()->getConexionBd();

            $query= "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto FROM actividades WHERE dirigida = 1 AND aforo - ocupacion > 0";
            $stmt = $conn->prepare($query);

            // Se ejecuta la consulta
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