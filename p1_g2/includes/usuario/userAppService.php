<?php

// Se requiere el archivo que contiene la fábrica de usuarios
require("userFactory.php");

class userAppService
{
    // Variable estática para almacenar una única instancia de la clase (Patrón Singleton)
    private static $instance;

    // Método para obtener la única instancia de userAppService
    public static function GetSingleton()
    {
        // Si la instancia no está creada, se crea una nueva
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance; // Retorna la instancia única
    }

    // Constructor privado para evitar la creación de múltiples instancias
    private function __construct()
    {
    } 

    // Método para iniciar sesión
    public function login($userDTO)
    {
        // Se obtiene una instancia del DAO de usuario a través de la fábrica
        $IUserDAO = userFactory::CreateUser();
        
        // Se intenta iniciar sesión con los datos proporcionados
        $foundedUserDTO = $IUserDAO->login($userDTO);

        return $foundedUserDTO;
    }

    // Método para registrar un nuevo usuario
    public function create($userDTO)
    {
        $IUserDAO = userFactory::CreateUser();

        $createdUserDTO = $IUserDAO->create($userDTO);

        return $createdUserDTO;
    }

    // Método para verificar si un correo ya está registrado en la base de datos
    public function existsByEmail($userDTO)
    {
        $IUserDAO = userFactory::CreateUser();

        $emailUserDTO = $IUserDAO->existsByEmail($userDTO);

        return $emailUserDTO;
    }

    // Método para verificar si un ID de usuario ya existe en la base de datos
    public function existsById($userDTO)
    {
        $IUserDAO = userFactory::CreateUser();

        $idUserDTO = $IUserDAO->existsById($userDTO);

        return $idUserDTO;
    }

}

?>