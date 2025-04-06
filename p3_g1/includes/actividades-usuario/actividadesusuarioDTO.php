<?php

// Definición de la clase actividadDTO para representar actividades
class actividadesusuarioDTO
{
    // Atributos privados para evitar acceso directo
    private $id_usuario;
    private $id_actividad;
    

    // Constructor para inicializar una actividad con sus datos
    public function __construct($id_usuario, $id_actividad)
    {
        $this->id_usuario = $id_usuario;
        $this->id_actividad = $id_actividad;
        
    }

    // Métodos públicos para obtener los valores de los atributos

    // Devuelve el id del usuario
    public function id_usuario()
    {
        return $this->id_usuario;
    }

    // Devuelve el id de la actividad
    public function id_actividad()
    {
        return $this->id_actividad;
    }
}
?>
