<?php

namespace includes\usuario;

// Define una interfaz para la gestión de usuarios
interface IUser
{
    // Método para iniciar sesión con un usuario
    public function login($userDTO);

    // Método para registrar un nuevo usuario
    public function create($userDTO);

    // Método para verificar si un correo ya está registrado
    public function existsByEmail($userDTO);

    // Método para verificar si un ID de usuario ya existe
    public function existsById($userDTO);

    //método que me devuelve todos los usuarios
    public function getTodosLosUsuarios();

    

}

?>