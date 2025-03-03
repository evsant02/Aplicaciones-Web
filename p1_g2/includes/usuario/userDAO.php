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
        $foundedUserDTO = $this->buscaUsuario($userDTO->username());
        
        if ($foundedUserDTO && self::testHashPassword( $userDTO->password(), $foundedUserDTO->password())) 
        {
            return $foundedUserDTO;
        } 

        return false;
    }

    private function buscaUsuario($username)
    {
        $escUserName = trim($this->realEscapeString($username)); // TRIM para evitar espacios extra
    
        $conn = application::getInstance()->getConexionBd();
    
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
    
        $query = "SELECT Id, UserName, Password FROM Usuarios WHERE UserName = ?";
    
        $stmt = $conn->prepare($query);
        
        if (!$stmt) {
            die("Error al preparar la consulta: " . $conn->error);
        }
    
        $stmt->bind_param("s", $escUserName);
        
        if (!$stmt->execute()) {
            die("Error en la consulta: " . $stmt->error);
        }
    
        $Id = null;
        $UserName = null;
        $Password = null;
    
        $stmt->bind_result($Id, $UserName, $Password);
    
        var_dump($escUserName); // Para ver qué valor se busca
        if ($stmt->fetch()) {
            var_dump($UserName, $Password); // Para ver qué valores se obtienen
            $stmt->close();
            return new userDTO($Id, $UserName, $Password);
        }
    
        return false; // No encontró el usuario
    }
    

    public function create($userDTO)
    {
        $createdUserDTO = false;

        try
        {
            $escUserName = $this->realEscapeString($userDTO->userName());

            $hashedPassword = self::hashPassword($userDTO->password());

            $conn = application::getInstance()->getConexionBd();

            $query = "INSERT INTO Usuarios(UserName, Password) VALUES (?, ?)";

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ss", $escUserName, $hashedPassword);

            if ($stmt->execute())
            {
                $idUser = $conn->insert_id;
                
                $createdUserDTO = new userDTO($idUser, $userDTO->userName(), $userDTO->password());

                return $createdUserDTO;
            }
        }
        catch(mysqli_sql_exception $e)
        {
            // código de violación de restricción de integridad (PK)

            if ($conn->sqlstate == 23000) 
            { 
                throw new userAlreadyExistException("Ya existe el usuario '{$userDTO->userName()}'");
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
        
        $result = password_verify($password, $hashedPassword);
        var_dump($result);
        return $result;
    }
}
?>