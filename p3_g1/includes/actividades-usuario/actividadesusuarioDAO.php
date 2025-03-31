
<?php
// Se incluyen las dependencias necesarias
require_once("IActividadesusuario.php");
require_once("actividadesusuarioDTO.php");
require_once(__DIR__ . "/../comun/baseDAO.php");

// Clase que implementa el acceso a la base de datos para la gestión de actividades
class actividadesusuarioDAO extends baseDAO implements IActividadesusuario
{
    // Constructor vacío
    public function __construct()
    {
    }

    // Método para crear una nueva entrada en la tabla actividaddes-usuario en la base de datos
    public function crear($actividadesusuarioDTO)
    {
        try {
            // Obtener conexión con la base de datos
            $conn = application::getInstance()->getConexionBd();

            //escape de strings para evitar inyeccion sql
            $escid_usuario = $this->realEscapeString($actividadesusuarioDTO->id_usuario());
            $escid_actividad = $this->realEscapeString($actividadesusuarioDTO->id_actividad());

            // Consulta SQL para insertar una nueva actividad
            $query = "INSERT INTO actividades-usuario (id_usuario, id_actividad) VALUES (?, ?)";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }


            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("ssss", 
                $escid_usuario, 
                $escid_actividad
            );

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el ID generado por la inserción
                return new actividadesusuarioDTO($escid_usuario, $escid_actividad);
            }
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close(); // Asegura que el statement se cierra siempre
            }
        }
    }

    // Método para eliminar una actividad existente
    public function eliminar($actividadesusuarioDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para eliminar una actividad por su ID
            $query = "DELETE FROM actividades-usuario WHERE id = ?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            
            // Se vincula el parámetro ID
            $escid = $this -> realEscapeString($actividadesusuarioDTO ->id_usuario());
            $stmt->bind_param("i", $escid);
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
    /*
    public function modificar($actividadesusuarioDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para actualizar los datos de una actividad
            $query = "UPDATE actividades-usuario SET id_usuario = ?, id_actividad = ? WHERE id_usuario = ? AND id_actividad = ?";
            $stmt = $conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

           //escape de strings para evitar inyecciones de SQLid_usuario = $this->realEscapeString($actividadesusuarioDTO->nombre());
           $esclocalizacion = $this->realEscapeString($actividadesusuarioDTO->localizacion());
           $escfecha_hora = $this->realEscapeString($actividadesusuarioDTO->fecha_hora());
           $escdescripcion = $this->realEscapeString($actividadesusuarioDTO->descripcion());
           $escid = $this -> realEscapeString($actividadesusuarioDTO ->id());
           $escocupacion = $this->realEscapeString($actividadesusuarioDTO->ocupacion());
           $escfoto = $this->realEscapeString($actividadesusuarioDTO->foto());

           // Se vinculan los parámetros
           $stmt->bind_param("ssssi", 
               id_usuario, 
               $esclocalizacion, 
               $escfecha_hora, 
               $escdescripcion,
               $escid,
               $escocupacion,
               $escfoto
           );


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
        */

    // Método para obtener una actividad por su ID
    /*
    public function getActividadById($id)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener una actividad específica
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Se vincula el parámetro ID
            $stmt->bind_param("i", $id);


            // Se ejecuta la consulta
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }

            // Variables para almacenar los resultados
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);

            // Si se encuentra la actividad, se devuelve un objeto actividadesusuarioDTO
            if ($stmt->fetch()) {
                return new actividadesusuarioDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto);
            }
        } catch (Exception $e) {
            throw new Exception("Error al obtener la actividad: " . $e->getMessage());
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
        return null; // No se encontró la actividad
    } */

    // Método para obtener todas las actividades a las que está apuntado un cliente (por completar)
    public function obtenerTodasLasActividades()
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener todas las actividades
            $query = "SELECT id_usuario, id_actividad  FROM actividades-usuario";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Se ejecuta la consulta
            $stmt->execute();
            $stmt->bind_result($id_usuario, $id_actividad);

            $actividades = [];
            while ($stmt->fetch()) {
                $actividades[] = new actividadesusuarioDTO($id_usuario, $id_actividad);
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


    //metodo para obtener los id e actividades
    public function getActividadesUsuario($actividadesusuarioDTO) {
        $escId = trim($this->realEscapeString($actividadesusuarioDTO->id_usuario()));
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT id_actividad FROM actividades-usuario WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $actividades = array();
    
        try {
            $stmt->bind_param("s", $escId);
            $stmt->execute();
            $stmt->bind_result($idActividad);
    
            while ($stmt->fetch()) {
                $actividades[] = $idActividad;
            }
            
            return $actividades;
        } finally {
            $stmt->close();
        }
    }

}
?>
