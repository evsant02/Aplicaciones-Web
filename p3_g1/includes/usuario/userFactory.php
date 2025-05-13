<?php

namespace includes\usuario;

use includes\usuario\userDAO;

class userFactory
{
    // Método estático que crea una instancia de userDAO (que implementa la interfaz IUser)
    public static function CreateUser() : IUser
    {
        // Crea una instancia de userDAO
        $userDAO = new userDAO();        
        
        // Devuelve la instancia creada, que es un objeto de tipo IUser
        return $userDAO;
    }
}

?>