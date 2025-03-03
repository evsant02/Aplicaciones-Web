<?php

require("userDAO.php");

class userFactory
{
    public static function CreateUser() : IUser
    {
        $userDAO = new userDAO();        
        
        return $userDAO;
    }
}

?>