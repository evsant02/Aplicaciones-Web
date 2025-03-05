<?php

interface IUser
{
    public function login($userDTO);

    public function create($userDTO);

<<<<<<< HEAD
    public function existsByEmail($correo);
=======
    public function existsByEmail($userDTO);

    public function existsById($userDTO);
>>>>>>> Umaima
}
?>