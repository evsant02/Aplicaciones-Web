<?php

// Se requieren los archivos necesarios para la funcionalidad de la clase
//require_once("IUser.php"); // Interfaz que define los métodos de usuario
//require_once("userDTO.php"); // Objeto de transferencia de datos para usuarios
//require_once(__DIR__ . "/../comun/baseDAO.php"); // Clase base para acceso a la base de datos

namespace includes\usuario;
use includes\comun\baseDAO;
use includes\application;
use includes\excepciones\EmailAlreadyExistException;
use includes\excepciones\UserAlreadyExistException;
use includes\excepciones\UserNotFoundException;

//require_once(__DIR__ . "/../../excepciones/user/UserAlreadyExistException.php");
//require_once(__DIR__ . "/../../excepciones/user/UserNotFoundException.php");
//require_once(__DIR__ . "/../../excepciones/user/EmailAlreadyExistException.php");

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
        $escid = trim($this->realEscapeString($id));
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT id, nombre, apellidos, password, fecha_nacimiento, tipo, correo FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($query);

        try {
            $stmt->bind_param("s", $escid);
            
            $stmt->execute();

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
        try {
            /*if ($this->existsById($userDTO)) {
                throw new UserAlreadyExistException("Ya existe el usuario '{$userDTO->id()}'");
            }
            
            if ($this->existsByEmail($userDTO)) {
                throw new EmailAlreadyExistException($userDTO->correo());
            }*/

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
                    $createUserDTO=new userDTO($idUser, $escNombre, $escApellidos, $hashedPassword, $escFechaNacimiento, $escTipo, $escCorreo);
                }

              
            } finally {
                $stmt->close();
            }
        } catch (\mysqli_sql_exception $e) {
            if ($e->getCode() == 23000) {
                throw new UserAlreadyExistException("Ya existe el usuario '{$userDTO->id()}'");
            }
        
        }
        return $createUserDTO;
    }
    // Método para cifrar una contraseña usando bcrypt
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private static function testHashPassword($password, $hashedPassword)
    {
        if (strlen($hashedPassword) < 60 || substr($hashedPassword, 0, 4) !== '$2y$') {
            return $password === $hashedPassword;
        }
        return password_verify($password, $hashedPassword);
    }

    public function existsById($userDTO)
    {
        $id = trim($this->realEscapeString($userDTO->id()));
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT COUNT(*) FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($query);

        try {
            $stmt->bind_param("s", $id);

            $stmt->execute();
            
            $stmt->bind_result($count);
            $stmt->fetch();

            return $count > 0;
        
        } catch (\mysqli_sql_exception $e) {

            throw new UserNotFoundException("No se encontró el usuario con ID: '{$userDTO->id()}'");
         
        } finally {
            
            $stmt->close();
            
        }
    }

    public function existsByEmail($userDTO)
    {
        $correo = trim($this->realEscapeString($userDTO->correo()));
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT COUNT(*) FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($query);

        try {
           
            $stmt->bind_param("s", $correo);

            $stmt->execute();
            

            $stmt->bind_result($count);
            $stmt->fetch();

            return $count > 0;

        }catch (\mysqli_sql_exception $e) {

            throw new EmailAlreadyExistException("Ya existe un usuario con el email: '{$userDTO->correo()}'");

        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    //me devuelve todos los usuarios
    public function getTodosLosUsuarios(){
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT id FROM usuarios WHERE tipo = 1"; //solo los que sean usuarios (no voluntarios y no admin)
        $stmt = $conn->prepare($query);
        $idsUsuarios = array();
    
        try {
            $stmt->execute();
            $stmt->bind_result($id);
    
            while ($stmt->fetch()) {
                $idsUsuarios[] = $id; //solo guardo el id en el array
            }
        } finally {
            $stmt->close();
        }
    
        return $idsUsuarios;

    }


}

?>
