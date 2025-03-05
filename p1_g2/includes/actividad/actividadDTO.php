<?php

class actividadDTO
{
    private $id;

    private $nombre;

    private $localizacion;

    private $fecha_hora;

    private $descripcion;

    public function __construct($id, $nombre, $localizacion, $fecha_hora, $descripcion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->localizacion = $localizacion;
        $this->fecha_hora = $fecha_hora;
        $this->descripcion = $descripcion;
    }

    public function id()
    {
        return $this->id;
    }

    public function nombre()
    {
        return $this->nombre;
    }

    public function localizacion()
    {
        return $this->localizacion;
    }

    public function fecha_hora()
    {
        return $this->fecha_hora;
    }

    public function descripcion()
    {
        return $this->descripcion;
    }
}
?>