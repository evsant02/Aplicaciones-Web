<?php

namespace includes\actividadesusuario;

// Definición de la clase actividadesmensajesDTO para representar actividades-mensajes
class actividadesmensajesDTO
{
    // Atributos privados para evitar acceso directo
    private $id_usuario;
    private $id_actividad;
    private $mensaje;
    

    // Constructor para inicializar una actividad con sus datos
    public function __construct($id_usuario, $id_actividad, $mensaje)
    {
        $this->id_usuario = $id_usuario;
        $this->id_actividad = $id_actividad;
        $this->mensaje = $mensaje;
        
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

    
    // Devuelve el mensaje de la notificacion
    public function mensaje()
    {
        return $this->mensaje;
    }

}
?>
