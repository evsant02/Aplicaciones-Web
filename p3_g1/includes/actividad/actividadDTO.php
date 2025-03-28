<?php

// Definición de la clase actividadDTO para representar actividades
class actividadDTO
{
    // Atributos privados para evitar acceso directo
    private $id;
    private $nombre;
    private $localizacion;
    private $fecha_hora;
    private $descripcion;
    private $aforo;
    private $dirigida;
    private $ocupacion;

    // Constructor para inicializar una actividad con sus datos
    public function __construct($id, $nombre, $localizacion, $fecha_hora, $descripcion, $aforo, $dirigida, $ocupacion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->localizacion = $localizacion;
        $this->fecha_hora = $fecha_hora;
        $this->descripcion = $descripcion;
        $this->aforo = $aforo;
        $this->dirigida = $dirigida;
        $this->ocupacion = $ocupacion;
    }

    // Métodos públicos para obtener los valores de los atributos

    // Devuelve el ID de la actividad
    public function id()
    {
        return $this->id;
    }

    // Devuelve el nombre de la actividad
    public function nombre()
    {
        return $this->nombre;
    }

    // Devuelve la localización de la actividad
    public function localizacion()
    {
        return $this->localizacion;
    }

    // Devuelve la fecha y hora de la actividad
    public function fecha_hora()
    {
        return $this->fecha_hora;
    }

    // Devuelve la descripción de la actividad
    public function descripcion()
    {
        return $this->descripcion;
    }

    public function aforo()
    {
        return $this->aforo;
    }

    public function dirigida()
    {
        return $this->dirigida;
    }

    public function ocupacion()
    {
        return $this->ocupacion;
    }
}
?>
