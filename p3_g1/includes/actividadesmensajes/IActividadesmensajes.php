<?php
namespace includes\actividadesmensajes;

/**
 * Interfaz IActividad
 * Define los métodos necesarios para la gestión de actividades en el sistema.
 */
interface IActividadesmensajes
{
    /**
     * Inserta un nuevo mensaje para un usuario relacionado con una actividad.
     * @param actividadesmensajesDTO $dto Objeto con los datos del mensaje.
     * @return bool True si se insertó correctamente, false en caso contrario.
     */
    public function insertarMensaje($dto);

    /**
     * Obtiene todos los mensajes dirigidos a un usuario específico.
     * @param string $id_usuario ID del usuario.
     * @return actividadesmensajesDTO[] Array de objetos DTO con los mensajes.
     */
    

    public function getMensajesPorUsuario($id_usuario);
}

?>
