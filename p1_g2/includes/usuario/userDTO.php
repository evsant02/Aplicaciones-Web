<?php

// Clase userDTO (Data Transfer Object) para representar un usuario
class userDTO
{
    // Atributos privados del usuario
    private $id;
    private $nombre;
    private $apellidos;
    private $password;
    private $fecha_nacimiento;
    private $tipo;
    private $correo;

    // Constructor que inicializa los atributos del usuario
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

    // Métodos getter para acceder a los atributos (no hay setters para mantener la inmutabilidad)
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