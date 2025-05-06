<?php
namespace includes\foroNoticias;

use includes\actividadesmensajes\actividadesmensajesAppService;

class foroNoticias {
    private $id_usuario;

    public function __construct($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function inicializar() {
        //mirar los mensajes para el usuario
        //necesito otro metodo para generar el mensaje segun el tipo que sea????
    }
        
}
