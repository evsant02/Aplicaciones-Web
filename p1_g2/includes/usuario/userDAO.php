<?php

// Se requieren los archivos necesarios para la funcionalidad de la clase
require("IUser.php"); // Interfaz que define los métodos de usuario
require_once("userDTO.php"); // Objeto de transferencia de datos para usuarios
require(__DIR__ . "/../comun/baseDAO.php"); // Clase base para acceso a la base de datos
require("userAlreadyExistException.php"); // Excepción para usuarios duplicados

// Clase userDAO que extiende baseDAO e implementa la interfaz IUser
class userDAO extends baseDAO implements IUser
{
    // Constructor vacío
    public function __construct()
    {
    }

    // Método para iniciar sesión de un usuario
    public function login($userDTO)
    {
        // Busca el usuario en la base de datos por su ID
        $foundedUserDTO = $this->buscaUsuario($userDTO->id());

        // Si el usuario existe y la contraseña es correcta, lo devuelve
        if ($foundedUserDTO && self::testHashPassword($userDTO->password(), $foundedUserDTO->password())) 
        {
            return $foundedUserDTO;
        } 

        return false; // Si no existe o la contraseña es incorrecta, devuelve falso
    }

    // Método privado para buscar un usuario por ID en la base de datos
    private function buscaUsuario($id)
    {
        $escid = trim($this->realEscapeString($id)); // Limpia el ID de posibles espacios en blanco

        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Verifica si hubo un error de conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Consulta SQL para obtener los datos del usuario
        $query = "SELECT id, nombre, apellidos, password, fecha_nacimiento, tipo, correo FROM usuarios WHERE id = ?";

        $stmt = $conn->prepare($query);
        
        if (!$stmt) {
            die("Error al preparar la consulta: " . $conn->error);
        }

        // Asigna el parámetro a la consulta
        $stmt->bind_param("s", $escid);

        if (!$stmt->execute()) {
            die("Error en la consulta: " . $stmt->error);
        }

        // Variables para almacenar los resultados de la consulta
        $stmt->bind_result($id, $nombre, $apellidos, $password, $fecha_nacimiento, $tipo, $correo);

        var_dump($escid); // Debugging: muestra el ID buscado

        // Si se encuentra un usuario, lo devuelve como un objeto userDTO
        if ($stmt->fetch()) {
            var_dump($id, $password); // Debugging: muestra los valores obtenidos
            $stmt->close();
            return new userDTO($id, $nombre, $apellidos, $password, $fecha_nacimiento, $tipo, $correo);
        }

        return false; // Si no encuentra el usuario, devuelve falso
    }

    // Método para crear un nuevo usuario en la base de datos
    public function create($userDTO)
    {
        $createdUserDTO = false;

        try
        {
            // Escapa los valores para evitar inyección SQL
            $escId = $this->realEscapeString($userDTO->id());
            $escNombre = $this->realEscapeString($userDTO->nombre());
            $escApellidos = $this->realEscapeString($userDTO->apellidos());
            $escFechaNacimiento = $this->realEscapeString($userDTO->fecha_nacimiento());
            $escTipo = $this->realEscapeString($userDTO->tipo());
            $escCorreo = $this->realEscapeString($userDTO->correo());

            // Cifra la contraseña antes de almacenarla
            $hashedPassword = self::hashPassword($userDTO->password());

            var_dump($escId, $escNombre, $escApellidos, $hashedPassword, $escFechaNacimiento, $escTipo, $escCorreo); // Debugging

            // Obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para insertar un nuevo usuario
            $query = "INSERT INTO Usuarios (id, nombre, apellidos, password, fecha_nacimiento, tipo, correo) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Asigna los parámetros a la consulta
            $stmt->bind_param("sssssss", $escId, $escNombre, $escApellidos, $hashedPassword, $escFechaNacimiento, $escTipo, $escCorreo);

            // Ejecuta la consulta y verifica si se insertó correctamente
            if ($stmt->execute()) {
                $idUser = $conn->insert_id; // Obtiene el ID del usuario insertado

                $createdUserDTO = new userDTO($idUser, $escNombre, $escApellidos, $hashedPassword, $escFechaNacimiento, $escTipo, $escCorreo);
                $stmt->close();
                return $createdUserDTO;
            }
            $stmt->close();
        }
        catch (mysqli_sql_exception $e)
        {
            // Maneja la excepción si el usuario ya existe en la base de datos
            if ($conn->sqlstate == 23000) 
            { 
                throw new userAlreadyExistException("Ya existe el usuario '{$userDTO->id()}'");
            }

            throw $e;
        }

        return $createdUserDTO;
    }

    // Método para cifrar una contraseña usando bcrypt
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    // Método para verificar una contraseña ingresada con la almacenada en la base de datos
    private static function testHashPassword($password, $hashedPassword)
    {
        var_dump($password);
        var_dump($hashedPassword);

        // Si la contraseña almacenada no tiene formato bcrypt, se compara en texto plano
        if (strlen($hashedPassword) < 60 || substr($hashedPassword, 0, 4) !== '$2y$') {
            return $password === $hashedPassword;
        }

        $result = password_verify($password, $hashedPassword);
        var_dump($result);
        return $result;
    }

    // Método para verificar si un correo ya está registrado en la base de datos
    public function existsByEmail($userDTO)
    {
        $correo = trim($this->realEscapeString($userDTO->correo()));

        $conn = application::getInstance()->getConexionBd();
    
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
    
        $query = "SELECT COUNT(*) FROM usuarios WHERE correo = ?";
    
        $stmt = $conn->prepare($query);
        
        if (!$stmt) {
            die("Error al preparar la consulta: " . $conn->error);
        }
    
        $stmt->bind_param("s", $correo);
        
        if (!$stmt->execute()) {
            die("Error en la consulta: " . $stmt->error);
        }

        $count = null;
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
    
        return $count > 0;
    }

    // Método para verificar si un usuario existe por su ID
    public function existsById($userDTO)
    {
        $id = trim($this->realEscapeString($userDTO->id()));

        $conn = application::getInstance()->getConexionBd();
    
        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }
    
        $query = "SELECT COUNT(*) FROM usuarios WHERE id = ?";
    
        $stmt = $conn->prepare($query);
    
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conn->error);
        }
    
        $stmt->bind_param("s", $id);
    
        if (!$stmt->execute()) {
            throw new Exception("Error en la consulta: " . $stmt->error);
        }

        $count = null;
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
    
        return $count > 0;
    }
}

?>