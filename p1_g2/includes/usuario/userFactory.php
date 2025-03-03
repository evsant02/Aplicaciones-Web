<?php

require("userDAO.php");
require("userMock.php");

class userFactory
{
    public static function CreateUser() : IUser
    {
        $userDAO = new userDAO();        
        
        return $userDAO;
    }
}

?>