<?php

namespace includes\actividadesusuario;

// Se incluyen las dependencias necesarias
//require_once("IActividadesusuario.php");
//require_once("actividadesusuarioDTO.php");
//require_once(__DIR__ . "/../comun/baseDAO.php");

use includes\comun\baseDAO;
use includes\application;

// Clase que implementa el acceso a la base de datos para la gestión de actividades
class actividadesusuarioDAO extends baseDAO implements IActividadesusuario
{
    // Constructor vacío
    public function __construct()
    {
    }

    
    //metodo para obtener los id e actividades
    public function getActividadesUsuario($id_usuario) {
        $escId = trim($this->realEscapeString($id_usuario));
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT id_actividad FROM `actividades-usuario` WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $actividades = array();
    
        try {
            $stmt->bind_param("s", $escId);
            $stmt->execute();
            $stmt->bind_result($idActividad);
    
            while ($stmt->fetch()) {
                $actividades[] = $idActividad;
            }
            
            return $actividades;
        } finally {
            $stmt->close();
        }
    }

    public function isRegistrado($id_usuario, $id_actividad){
        $conn = application::getInstance()->getConexionBd();
        $escId_usuario = trim($this->realEscapeString($id_usuario));
        $escId_actividad = trim($this->realEscapeString($id_actividad));
        $query = "SELECT id_actividad FROM `actividades-usuario` WHERE id_usuario = ? AND id_actividad= ? ";
        $stmt = $conn->prepare($query);
        try {
            $stmt->bind_param("ss", $escId_usuario, $escId_actividad);
            $stmt->execute();
            $stmt->store_result();
            $verdadero=$stmt->num_rows();
            return $verdadero;
        } finally {
            $stmt->close();
        }
        
    }



    public function apuntarUsuario($id_actividad, $id_usuario){
        try {
            // Obtener conexión con la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para insertar una nueva actividad
            $query = "INSERT INTO `actividades-usuario` (id_usuario, id_actividad) VALUES (?, ?)";
            $stmt = $conn->prepare($query);

            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("si", 
                $id_usuario, 
                $id_actividad
            );

            // Ejecutar la consulta
            $stmt->execute();
        } finally {
            if ($stmt) {
                $stmt->close(); // Asegura que el statement se cierra siempre
            }
        }
    }

    public function bajaUsuario($id_actividad, $id_usuario) {
        try {
            // Obtener conexión con la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para insertar una nueva actividad
            $query = "DELETE FROM `actividades-usuario` WHERE id_usuario = ? AND id_actividad = ? ";
            $stmt = $conn->prepare($query);

            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("si", 
                $id_usuario, 
                $id_actividad
            );

            // Ejecutar la consulta
            $stmt->execute();
          
        } finally {
            if ($stmt) {
                $stmt->close(); // Asegura que el statement se cierra siempre
            }
        }
    }

    public function bajaActividad($id_actividad) { //se dan de baja a aquellos usuarios que estuvieran apuntados a la actividad que dirigía el voluntario que se da de baja
        try {
            // Obtener conexión con la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para insertar una nueva actividad
            $query = "DELETE FROM `actividades-usuario` WHERE id_actividad = ? ";
            $stmt = $conn->prepare($query);

            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("i", 
                $id_actividad
            );

            // Ejecutar la consulta
            $stmt->execute();
          
        } finally {
            if ($stmt) {
                $stmt->close(); // Asegura que el statement se cierra siempre
            }
        }
    }



    public function obtenerUsuariosInscritos($id_actividad){ //me devuleve los id de los usuarios inscritos para esa actividad
        //$escId = trim($this->realEscapeString($id_actividad));
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT id_usuario FROM `actividades-usuario` WHERE id_actividad = ?";
        $stmt = $conn->prepare($query);
        $usuarios = array();
    
        try {
            //$stmt->bind_param("s", $escId);
            $stmt->bind_param("i", $id_actividad);
            $stmt->execute();
            $stmt->bind_result($idUsuario);
    
            while ($stmt->fetch()) {
                $usuarios[] = $idUsuario;
            }
            
            return $usuarios;
        } finally {
            $stmt->close();
        }

    }

}
?>
