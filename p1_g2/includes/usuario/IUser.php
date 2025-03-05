<?php

interface IUser
{
    public function login($userDTO);

    public function create($userDTO);

    public function existsByEmail($userDTO);

    public function existsById($userDTO);
}
?>