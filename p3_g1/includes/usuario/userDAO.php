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

        $query = "SELECT id, nombre, apellidos, password, fecha_nacimiento, tipo, correo FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($query);

        try {
            $stmt->bind_param("s", $escid);

            $stmt->execute();
            /*
            if (!$stmt->execute()) {
                throw new Exception("Error en la consulta: " . $stmt->error);
            }
            */

            $stmt->bind_result($id, $nombre, $apellidos, $password, $fecha_nacimiento, $tipo, $correo);

            if ($stmt->fetch()) {
                return new userDTO($id, $nombre, $apellidos, $password, $fecha_nacimiento, $tipo, $correo);
            }

            return false;
        } finally {
            $stmt->close();
        }
    }

    // Método para crear un nuevo usuario en la base de datos
    public function create($userDTO)
    {
        $createdUserDTO = false;

        try {
            $escId = $this->realEscapeString($userDTO->id());
            $escNombre = $this->realEscapeString($userDTO->nombre());
            $escApellidos = $this->realEscapeString($userDTO->apellidos());
            $escFechaNacimiento = $this->realEscapeString($userDTO->fecha_nacimiento());
            $escTipo = $this->realEscapeString($userDTO->tipo());
            $escCorreo = $this->realEscapeString($userDTO->correo());

            $hashedPassword = self::hashPassword($userDTO->password());

            $conn = application::getInstance()->getConexionBd();
            $query = "INSERT INTO Usuarios (id, nombre, apellidos, password, fecha_nacimiento, tipo, correo) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($query);

            try {
                $stmt->bind_param("sssssis", $escId, $escNombre, $escApellidos, $hashedPassword, $escFechaNacimiento, $escTipo, $escCorreo);

                if ($stmt->execute()) {
                    $idUser = $conn->insert_id;
                    $createdUserDTO = new userDTO($idUser, $escNombre, $escApellidos, $hashedPassword, $escFechaNacimiento, $escTipo, $escCorreo);
                }
            } finally {
                $stmt->close();
            }
        } catch (mysqli_sql_exception $e) {
            if ($conn->sqlstate == 23000) { 
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

        if (strlen($hashedPassword) < 60 || substr($hashedPassword, 0, 4) !== '$2y$') {
            return $password === $hashedPassword;
        }

        $result = password_verify($password, $hashedPassword);
        return $result;
    }

    // Método para verificar si un usuario existe por su ID
    public function existsById($userDTO)
    {
        $id = trim($this->realEscapeString($userDTO->id()));
        $conn = application::getInstance()->getConexionBd();

        $query = "SELECT COUNT(*) FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($query);

        try {
            $stmt->bind_param("s", $id);
            
            $stmt->execute();
            /*
            if (!$stmt->execute()) {
                throw new Exception("Error en la consulta: " . $stmt->error);
            }
            */

            $stmt->bind_result($count);
            $stmt->fetch();

            return $count > 0;
        } finally {
            $stmt->close();
        }
    }

    // Método para verificar si un correo ya está registrado en la base de datos
    public function existsByEmail($userDTO)
    {
        $correo = trim($this->realEscapeString($userDTO->correo()));
        $conn = application::getInstance()->getConexionBd();

        $query = "SELECT COUNT(*) FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($query);

        try {
            $stmt->bind_param("s", $correo);

            $stmt->execute()
            /*
            if (!$stmt->execute()) {
                throw new Exception("Error en la consulta: " . $stmt->error);
            }
            */

            $stmt->bind_result($count);
            $stmt->fetch();

            return $count > 0;
        } finally {
            $stmt->close();
        }
    }
}

?>
