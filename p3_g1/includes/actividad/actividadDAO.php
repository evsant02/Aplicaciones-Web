<?php
namespace includes\actividad;

use includes\comun\baseDAO;
use includes\application;
use includes\excepciones\DuplicateActivityException;
use includes\usuario\userDTO;

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
            $escaforo = $this->realEscapeString($actividadDTO->aforo());
            $escdirigida = $this->realEscapeString($actividadDTO->dirigida());
            $escocupacion = $this->realEscapeString($actividadDTO->ocupacion());
            $escfoto = $this->realEscapeString($actividadDTO->foto());
            $esccategoria = $this->realEscapeString($actividadDTO->categoria());

            // Consulta SQL para insertar una nueva actividad
            $query = "INSERT INTO actividades (nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto, categoria) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("ssssiiisi", 
                $escnombre, 
                $esclocalizacion, 
                $escfecha_hora, 
                $escdescripcion,
                $escaforo,
                $escdirigida,
                $escocupacion,
                $escfoto,
                $esccategoria
            );

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el ID generado por la inserción
                $idActividad = $conn->insert_id;
                return new actividadDTO($idActividad, $escnombre, $esclocalizacion, $escfecha_hora, $escdescripcion, $escaforo, $escdirigida, $escocupacion, $escfoto, $esccategoria);
            }
        } catch (\mysqli_sql_exception $e) {
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
            $query = "UPDATE actividades SET nombre = ?, localizacion = ?, fecha_hora = ?, descripcion = ?, aforo = ?, dirigida = ?, ocupacion = ?, foto = ?, categoria = ? WHERE id = ?";
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
           $esccategoria = $this->realEscapeString($actividadDTO->categoria());

           // Se vinculan los parámetros
           $stmt->bind_param("ssssiiisii", 
               $escnombre, 
               $esclocalizacion, 
               $escfecha_hora, 
               $escdescripcion,
               $escaforo,
               $escdirigida,
               $escocupacion,
               $escfoto,
               $esccategoria,
               $escid
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
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto, categoria FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);

            // Se vincula el parámetro ID
            $stmt->bind_param("i", $id);

            // Se ejecuta la consulta
            $stmt->execute();

            // Variables para almacenar los resultados
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $categoria);

            // Si se encuentra la actividad, se devuelve un objeto actividadDTO
            if ($stmt->fetch()) {
                return new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $categoria);
            }
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
        return null; // No se encontró la actividad
    }

    // Método para obtener todas las actividades almacenadas en la base de datos
    public function obtenerTodasLasActividades($limit, $offset)
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener todas las actividades
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto, categoria 
                FROM actividades 
                LIMIT ? OFFSET ?";
            $stmt = $conn->prepare($query);

            $stmt->bind_param("ii", $limit, $offset);

            // Se ejecuta la consulta
            $stmt->execute();
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $categoria);

            $actividades = [];
            while ($stmt->fetch()) {
                $actividades[] = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $categoria);
            }

            $queryTotal = "SELECT COUNT(*) as total FROM actividades";
            $stmtTotal = $conn->prepare($queryTotal);
            $stmtTotal->execute();
            $stmtTotal->bind_result($totalActividades);
            $stmtTotal->fetch();
            $stmtTotal->close();
            
            return [
                'actividades' => $actividades,
                'total' => $totalActividades
            ];

        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }


    //Método para obtener actividades que todavia no están dirigidas por un usuario
    public function obtenerActSinDirigir($limit, $offset) {
        try {
            $conn = application::getInstance()->getConexionBd();
    
            // Consulta modificada: solo actividades no dirigidas y futuras
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto, categoria 
                      FROM actividades 
                      WHERE dirigida = 0 AND fecha_hora > NOW()
                      LIMIT ? OFFSET ?";
                      
            $stmt = $conn->prepare($query);

            $stmt->bind_param("ii", $limit, $offset);
    
            // Se ejecuta la consulta
            $stmt->execute();
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $categoria);
    
            $actividades = [];
            while ($stmt->fetch()) {
                $actividades[] = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $categoria);
            }
    
            $queryTotal = "SELECT COUNT(*) as total FROM actividades WHERE dirigida = 0 AND fecha_hora > NOW()";
            $stmtTotal = $conn->prepare($queryTotal);
            $stmtTotal->execute();
            $stmtTotal->bind_result($totalActividades);
            $stmtTotal->fetch();
            $stmtTotal->close();
            
            return [
                'actividades' => $actividades,
                'total' => $totalActividades
            ];
    
        } finally {
            if (isset($stmt) && $stmt) {
                $stmt->close();
            }
        }
    }

    public function obtenerActSinCompletar($limit, $offset) {
        try {
            $conn = application::getInstance()->getConexionBd();
            $userId = application::getInstance()->getUserDTO()->id();
    
            // Añade filtro de fecha futura
            $query = "SELECT id, nombre, localizacion, fecha_hora, descripcion, aforo, dirigida, ocupacion, foto, categoria 
                      FROM actividades 
                      WHERE dirigida = 1 
                        AND aforo - ocupacion > 0 
                        AND fecha_hora > NOW()
                        AND id NOT IN (
                            SELECT id_actividad 
                            FROM `actividades-usuario` 
                            WHERE id_usuario = ?
                        )
                      LIMIT ? OFFSET ?";
    
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sii", $userId, $limit, $offset); // Se pasa el parámetro de forma segura
    
            // Ejecutar la consulta
            $stmt->execute();
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $categoria);
    
            $actividades = [];
            while ($stmt->fetch()) {
                $actividades[] = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $categoria);
            }
    
            $queryTotal = "SELECT COUNT(*) as total FROM actividades 
                      WHERE dirigida = 1 
                        AND aforo - ocupacion > 0 
                        AND fecha_hora > NOW()
                        AND id NOT IN (
                            SELECT id_actividad 
                            FROM `actividades-usuario` 
                            WHERE id_usuario = ?
                        )";
            $stmtTotal = $conn->prepare($queryTotal);
            $stmtTotal->bind_param("s", $userId);
            $stmtTotal->execute();
            $stmtTotal->bind_result($totalActividades);
            $stmtTotal->fetch();
            $stmtTotal->close();
            
            return [
                'actividades' => $actividades,
                'total' => $totalActividades
            ];
    
        } finally {
            if (isset($stmt) && $stmt) {
                $stmt->close();
            }
        }
    }

    public function annadirusuario($id_actividad){
        $conn = application::getInstance()->getConexionBd();
        $query = "UPDATE actividades SET ocupacion = ocupacion + 1 WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Se vincula el parámetro ID
        $stmt->bind_param("i", $id_actividad);

        // Se ejecuta la consulta
        $resultado = $stmt->execute();
        return $resultado;
    }


    public function annadirVoluntario($id_actividad){
        $conn = application::getInstance()->getConexionBd();
        $query = "UPDATE actividades SET dirigida = 1 WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Se vincula el parámetro ID
        $stmt->bind_param("i", $id_actividad);

        // Se ejecuta la consulta
        $resultado = $stmt->execute();
        return $resultado;
    }

    public function borrarUsuario($id_actividad) {
        $conn = application::getInstance()->getConexionBd();
        $query = "UPDATE actividades SET ocupacion = ocupacion - 1 WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Se vincula el parámetro ID
        $stmt->bind_param("i", $id_actividad);

        // Se ejecuta la consulta
        $resultado = $stmt->execute();
        return $resultado;
    }

    public function borrarVoluntario($id_actividad) {
        $conn = application::getInstance()->getConexionBd();
        $query = "UPDATE actividades SET dirigida = 0, ocupacion = 0 WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Se vincula el parámetro ID
        $stmt->bind_param("i", $id_actividad);

        // Se ejecuta la consulta
        $resultado = $stmt->execute();
        return $resultado;
    }
     
    public function nombreVoluntario($id_actividad){
        try{
            $conn = application::getInstance()->getConexionBd();
            $query = "SELECT us.id, us.nombre, apellidos, fecha_nacimiento, tipo, correo FROM `actividades` act 
            JOIN `actividades-usuario` actus ON act.id = actus.id_actividad JOIN `usuarios` us ON actus.id_usuario = us.id
            WHERE act.id = ? AND us.tipo = 2";
            $stmt = $conn->prepare($query);

            // Se vincula el parámetro ID
            $stmt->bind_param("i", $id_actividad);

            $stmt->execute();
            $stmt->bind_result($id, $nombre, $apellidos, $fecha_nacimiento, $tipo, $correo);
            if($stmt->fetch()){
                return new userDTO($id, $nombre, $apellidos, null, $fecha_nacimiento, $tipo, $correo);
            }
        }
        finally{
            if($stmt){
                $stmt->close();
            }
        } 
        return null;
    }

    public function estaDirigida($id_actividad){
        try {
            $conn = application::getInstance()->getConexionBd();            
            $query = "SELECT dirigida FROM actividades WHERE id = ?";
            $stmt = $conn->prepare($query);
    
            // Se vincula el parámetro ID
            $stmt->bind_param("i", $id_actividad);
    
            // Se ejecuta la consulta
            $stmt->execute();
    
            // Vincula la variable al resultado
            $stmt->bind_result($dirigida);
    
            //si se obtiene un resultado, se devuelve si está dirigida o no
            if ($stmt->fetch()) {
                return $dirigida == 1;
            }
    
            // si no se encuentra 
            return false;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }
    
    //Uso de consultas SQL para devolver lista de actividaDTO coincidente con filtros
    public function actividadesFiltrar($desde, $hasta, $texto, $tipos, $usuario) {
        try {
            $conn = application::getInstance()->getConexionBd();
            //si no hay filtro por botones se incluyen todos
            if(empty($tipos)){
                $tipos = "Deporte,Salud,Cultura,Tecnologia";
            }
            $userId = application::getInstance()->getUserDTO()->id();
            $tiposArray = explode(',', $tipos);
            //incluir tantos parametros como valores haya en tipos
            $interrogaciones = implode(',', array_fill(0, count($tiposArray), '?'));
            //si no hay fechas valores a null
            if(empty($desde)&&empty($hasta)){
                $inicio = null;
                $final =null;
            }
            else{
                $inicio = date_create($desde)->format('Y-m-d H:i:s');
                $final = date_create($hasta)->format('Y-m-d H:i:s');
            }
            //buscar cualquier coincidencia con la palabra
            $palabras = "%" . $texto . "%"; 
            //filtrar por tipo de usuario, las consultas tienen pequennas diferencias para mostrar ciertas actividades
            if($usuario == 0){
                //caso con fechas, busca el texto y categorias seleccionadas en esas fechas
                if($inicio != null && $final != null){
                    $query = "SELECT a.id, a.nombre, a.localizacion, a.fecha_hora, a.descripcion, a.aforo, a.dirigida, a.ocupacion, a.foto, a.categoria 
                          FROM actividades a 
                          JOIN categorias c ON a.categoria = c.id
                          WHERE a.fecha_hora >= ? AND a.fecha_hora <= ?
                            AND (a.nombre LIKE ? OR a.localizacion LIKE ? OR a.descripcion LIKE ?)
                            AND (c.nombre) IN ($interrogaciones)
                          ORDER BY a.fecha_hora ASC";
                    $stmt = $conn->prepare($query);
                    //incluye el numero de s necesarias dependiendo del tipo de consulta
                    $types = str_repeat('s', 5 + count($tiposArray)); // all strings
                    $params = array_merge([$inicio, $final, $palabras, $palabras, $palabras], $tiposArray);
                    $stmt->bind_param($types, ...$params);
                }//no hay fechas, elimina la restriccion
                else if ($palabras != null && ($inicio == null && $final == null)){
                    $query = "SELECT a.id, a.nombre, a.localizacion, a.fecha_hora, a.descripcion, a.aforo, a.dirigida, a.ocupacion, a.foto, a.categoria 
                          FROM actividades a
                          JOIN categorias c ON a.categoria = c.id
                          WHERE (a.nombre LIKE ? OR a.localizacion LIKE ? OR a.descripcion LIKE ?)
                            AND LOWER(c.nombre) IN ($interrogaciones)";
                    $stmt = $conn->prepare($query);
                    $types = str_repeat('s', 3 + count($tiposArray)); // all strings
                    $params = array_merge([$palabras, $palabras, $palabras], $tiposArray);
                    $stmt->bind_param($types, ...$params); 
                }
            }
            //si es un voluntario añade la opcion de que no esten dirigidas
            else if($usuario==2){
                if($inicio != null && $final != null){
                    $query = "SELECT a.id, a.nombre, a.localizacion, a.fecha_hora, a.descripcion, a.aforo, a.dirigida, a.ocupacion, a.foto, a.categoria 
                          FROM actividades a 
                          JOIN categorias c ON a.categoria = c.id
                          WHERE a.fecha_hora >= ? AND a.fecha_hora <= ?
                            AND (a.nombre LIKE ? OR a.localizacion LIKE ? OR a.descripcion LIKE ?)
                            AND (c.nombre) IN ($interrogaciones) AND a.dirigida=0 AND a.fecha_hora > NOW()
                          ORDER BY a.fecha_hora ASC";
                    $stmt = $conn->prepare($query);
                    $types = str_repeat('s', 5 + count($tiposArray)); 
                    $params = array_merge([$inicio, $final, $palabras, $palabras, $palabras], $tiposArray);
                    $stmt->bind_param($types, ...$params);
                }
                else if ($palabras != null && ($inicio == null && $final == null)){
                    $query = "SELECT a.id, a.nombre, a.localizacion, a.fecha_hora, a.descripcion, a.aforo, a.dirigida, a.ocupacion, a.foto, a.categoria 
                          FROM actividades a
                          JOIN categorias c ON a.categoria = c.id
                          WHERE (a.nombre LIKE ? OR a.localizacion LIKE ? OR a.descripcion LIKE ?) AND a.dirigida = 0 AND a.fecha_hora > NOW()
                            AND LOWER(c.nombre) IN ($interrogaciones)";
                    $stmt = $conn->prepare($query);
                    $types = str_repeat('s', 3 + count($tiposArray)); 
                    $params = array_merge([$palabras, $palabras, $palabras], $tiposArray);
                    $stmt->bind_param($types, ...$params); 
                }
            }
            //si es un usuario normal solo muestra actividades dirigidas
            else{
                if($inicio != null && $final != null){
                    $query = "SELECT a.id, a.nombre, a.localizacion, a.fecha_hora, a.descripcion, a.aforo, a.dirigida, a.ocupacion, a.foto, a.categoria 
                          FROM actividades a 
                          JOIN categorias c ON a.categoria = c.id
                          WHERE a.fecha_hora >= ? AND a.fecha_hora <= ?
                            AND (a.nombre LIKE ? OR a.localizacion LIKE ? OR a.descripcion LIKE ?) AND a.id NOT IN (
                            SELECT id_actividad 
                            FROM `actividades-usuario` 
                            WHERE id_usuario = ?)
                            AND (c.nombre) IN ($interrogaciones) AND a.dirigida=1 AND aforo - ocupacion > 0 AND a.fecha_hora > NOW()
                          ORDER BY a.fecha_hora ASC";
                    $stmt = $conn->prepare($query);
                    $types = str_repeat('s', 6 + count($tiposArray)); 
                    $params = array_merge([$inicio, $final, $palabras, $palabras, $palabras, $userId], $tiposArray);
                    $stmt->bind_param($types, ...$params);
                }
                else if ($palabras != null && ($inicio == null && $final == null)){
                    $query = "SELECT a.id, a.nombre, a.localizacion, a.fecha_hora, a.descripcion, a.aforo, a.dirigida, a.ocupacion, a.foto, a.categoria 
                          FROM actividades a
                          JOIN categorias c ON a.categoria = c.id
                          WHERE (a.nombre LIKE ? OR a.localizacion LIKE ? OR a.descripcion LIKE ?) AND a.id NOT IN (
                            SELECT id_actividad 
                            FROM `actividades-usuario` 
                            WHERE id_usuario = ?) AND a.dirigida = 1 AND aforo - ocupacion > 0 AND a.fecha_hora > NOW()
                            AND LOWER(c.nombre) IN ($interrogaciones)";
                    $stmt = $conn->prepare($query);
                    $types = str_repeat('s', 4 + count($tiposArray)); // all strings
                    $params = array_merge([$palabras, $palabras, $palabras, $userId], $tiposArray);
                    $stmt->bind_param($types, ...$params); 
                }
            }
            $stmt->execute();
            $stmt->bind_result($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $categoria);
    
            $actividades = [];
            //rellena el array de DTOs
            while ($stmt->fetch()) {
                $actividades[] = new actividadDTO($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion, $foto, $categoria);
            }
            return $actividades;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

   }
?>