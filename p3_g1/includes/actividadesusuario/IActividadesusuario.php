<?php
namespace includes\actividadesusuario;

/**
 * Interfaz IActividad
 * Define los métodos necesarios para la gestión de actividades en el sistema.
 */
interface IActividadesusuario
{
    /**
     * Obtiene una actividad específica a partir de su ID.
     * @param int $id Identificador de la actividad.
     * @return actividadesusuarioDTO|null Retorna el objeto esus$actividadesusuarioDTO si se encuentra, o null si no existe.
     */

    //metodo para las actividades el usuario
    public function getActividadesUsuario($actividadesusuarioDTO);

    public function isRegistrado($id_usuario, $id_actividad);

    public function apuntarUsuario($id_actividad, $id_usuario);

    public function bajaUsuario($id_actividad, $id_usuario);

    public function bajaActividad($id_actividad);

    public function obtenerUsuariosInscritos($id_actividad);
    

}

?>
