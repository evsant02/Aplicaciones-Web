<?php

namespace includes\actividadesmensajes;


use includes\comun\baseDAO;
use includes\application;




// Clase que implementa el acceso a la base de datos para la gestión de actividades
class actividadesmensajesDAO extends baseDAO implements IActividadesmensajes
{
    // Constructor vacío
    public function __construct()
    {
    }

    
    public function getMensajesPorUsuario($id_usuario) {
        $escId = trim($this->realEscapeString($id_usuario));
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT id_actividad, mensaje FROM `actividades-mensajes` WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $mensajes = array();

        try {
            $stmt->bind_param("s", $escId);
            $stmt->execute();
            $stmt->bind_result($idActividad, $mensaje);

            while ($stmt->fetch()) {
                $mensajes[] = array(
                    'id_actividad' => $idActividad,
                    'mensaje' => $mensaje
                );
            }

            return $mensajes;
        } finally {
            $stmt->close();
        }
    }


    public function eliminarMensaje($idUsuario, $idActividad, $idMensaje) {
        $conn = application::getInstance()->getConexionBd();
        $query = "DELETE FROM `actividades-mensajes` WHERE id_usuario = ? AND id_actividad = ? AND mensaje = ?";
        $stmt = $conn->prepare($query);
    
        $stmt->bind_param("sii", $idUsuario, $idActividad, $idMensaje);
        $stmt->execute();
        $stmt->close();
    }



    //metodo para crear nuevo mnsj
    /*public function crearMensaje($mensajeDTO){
        try {
            //conexion con la bbdd
            $conn = application::getInstance()->getConexionBd();
    
            //escape de strings para evitar inyeccion sql
            $idActividad = $this->realEscapeString($mensajeDTO->id_actividad());
            $idUsuario = $this->realEscapeString($mensajeDTO->id_usuario());
            $tipoMensaje = $this->realEscapeString($mensajeDTO->mensaje());
    
            //consulta sql
            $query = "INSERT INTO `actividades-mensajes` (id_actividad, id_usuario, mensaje) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isi", $idActividad, $idUsuario, $tipoMensaje);
    
            //ejecuto la consulta sql
            if ($stmt->execute()) {
                //devuelvo el dto
                return new actividadesmensajesDTO($idActividad, $idUsuario, $tipoMensaje);
            }
    
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    
        return false;
    }*/


    public function crearMensaje($mensajeDTO) {
        $conn = application::getInstance()->getConexionBd();

        //escape de strings para evitar inyeccion sql
        $idActividad = $this->realEscapeString($mensajeDTO->id_actividad());
        $idUsuario = $this->realEscapeString($mensajeDTO->id_usuario());
        $tipoMensaje = $this->realEscapeString($mensajeDTO->mensaje());

        try {
            //elimino un mensaje previo si existe (mismo usuario, actividad y tipo)
            $this->eliminarMensaje($idUsuario, $idActividad, $tipoMensaje);

            //inserto el mensj
            $queryInsert = "INSERT INTO `actividades-mensajes` (id_actividad, id_usuario, mensaje) VALUES (?, ?, ?)";
            $stmtInsert = $conn->prepare($queryInsert);
            $stmtInsert->bind_param("isi", $idActividad, $idUsuario, $tipoMensaje);

            if ($stmtInsert->execute()) {
                //$stmtInsert->close();
                return new actividadesmensajesDTO($idActividad, $idUsuario, $tipoMensaje);
            }

            //$stmtInsert->close();

        } finally {
            if (isset($stmtInsert) && $stmtInsert) {
                $stmtInsert->close();
            }
        }

        return false;
    }




    //método que me devuelve el numero de mensajes que tiene un usuario
    public function tieneMensajes($id_usuario) {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT COUNT(*) FROM `actividades-mensajes` WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $id_usuario); 
        $stmt->execute();

        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }




}
?>
