<?php

class userDTO
{
    private $id;

    private $nombre;

    private $apellidos;

    private $password;

    private $fecha_nacimiento;

    private $tipo;

    private $correo;

    public function __construct($id, $nombre, $apellidos, $password, $fecha_nacimiento, $tipo, $correo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->password = $password;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->tipo = $tipo;
        $this->correo = $correo;
    }

    public function id()
    {
        return $this->id;
    }

    public function nombre()
    {
        return $this->nombre;
    }

    public function apellidos()
    {
        return $this->apellidos;
    }

    public function password()
    {
        return $this->password;
    }

    public function fecha_nacimiento()
    {
        return $this->fecha_nacimiento;
    }

    public function tipo()
    {
        return $this->tipo;
    }

    public function correo()
    {
        return $this->correo;
    }
}
?>