<?php

require("IUser.php");
require("userDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");
require("userAlreadyExistException.php");

class userDAO extends baseDAO implements IUser
{
    public function __construct()
    {

    }

    public function login($userDTO)
    {
        $foundedUserDTO = $this->buscaUsuario($userDTO->id());
        
        if ($foundedUserDTO && self::testHashPassword( $userDTO->password(), $foundedUserDTO->password())) 
        {
            return $foundedUserDTO;
        } 

        return false;
    }

    private function buscaUsuario($id)
    {
        $escid = trim($this->realEscapeString($id)); // TRIM para evitar espacios extra
    
        $conn = application::getInstance()->getConexionBd();
    
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
    
        $query = "SELECT id, nombre, apellidos, password, fecha_nacimiento, tipo, correo FROM usuarios WHERE id = ?";
    
        $stmt = $conn->prepare($query);
        
        if (!$stmt) {
            die("Error al preparar la consulta: " . $conn->error);
        }
    
        $stmt->bind_param("s", $escid);
        
        if (!$stmt->execute()) {
            die("Error en la consulta: " . $stmt->error);
        }
    
        $nombre = null;
        $id = null;
        $apellidos = null;
        $password = null;
        $fecha_nacimiento = null;
        $tipo = null;
        $correo = null;
    
        $stmt->bind_result($id, $nombre, $apellidos, $password, $fecha_nacimiento, $tipo, $correo);
    
        var_dump($escid); // Para ver qué valor se busca
        if ($stmt->fetch()) {
            var_dump($id, $password); // Para ver qué valores se obtienen
            $stmt->close();
            return new userDTO($id, $nombre, $apellidos, $password, $fecha_nacimiento, $tipo, $correo);
        }
    
        return false; // No encontró el usuario
    }
    

    public function create($userDTO)
    {
        $createdUserDTO = false;

        try
        {
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

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            $stmt->bind_param("issssss", $escId, $escNombre, $escApellidos, $hashedPassword, $escFechaNacimiento, $escTipo, $escCorreo);

            if ($stmt->execute()) {
                $idUser = $conn->insert_id;

                $createdUserDTO = new userDTO($idUser, $escNombre, $escApellidos, $hashedPassword, $escFechaNacimiento, $escTipo, $escCorreo);

                return $createdUserDTO;
            }
        }
        catch (mysqli_sql_exception $e)
        {
            // Código de violación de restricción de integridad (PK)
            if ($conn->sqlstate == 23000) 
            { 
                throw new userAlreadyExistException("Ya existe el usuario '{$userDTO->id()}'");
            }

            throw $e;
        }

        return $createdUserDTO;
    }

    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private static function testHashPassword($password, $hashedPassword)
    {
        var_dump($password);
        var_dump($hashedPassword);

        // Si la contraseña almacenada no empieza con "$2y$", es texto plano
        if (strlen($hashedPassword) < 60 || substr($hashedPassword, 0, 4) !== '$2y$') {
            return $password === $hashedPassword;
        }

        $result = password_verify($password, $hashedPassword);
        var_dump($result);
        return $result;

    }

    public function existsByEmail($correo)
    {
    /////////////////////////////////////////////////////7
    }

}
?>