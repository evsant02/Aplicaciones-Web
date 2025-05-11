<?php
namespace includes\actividad;

/**
 * Interfaz IActividad
 * Define los métodos necesarios para la gestión de actividades en el sistema.
 */
interface IActividad
{
    /**
     * Crea una nueva actividad en el sistema.
     * @param actividadDTO $actividadDTO Objeto que contiene los datos de la actividad a crear.
     * @return actividadDTO|null Retorna el objeto creado o null si hubo un error.
     */
    public function crear($actividadDTO);

    /**
     * Elimina una actividad existente.
     * @param actividadDTO $actividadDTO Objeto que representa la actividad a eliminar.
     * @return bool Retorna true si la eliminación fue exitosa, false en caso contrario.
     */
    public function eliminar($actividadDTO);

    /**
     * Modifica los datos de una actividad existente.
     * @param actividadDTO $actividadDTO Objeto con los nuevos datos de la actividad.
     * @return bool Retorna true si la modificación fue exitosa, false en caso contrario.
     */
    public function modificar($actividadDTO);

    /**
     * Obtiene todas las actividades almacenadas en el sistema.
     * @return array Retorna un array de objetos actividadDTO con todas las actividades.
     */
    public function obtenerTodasLasActividades($limit, $offset);

    /**
     * Obtiene una actividad específica a partir de su ID.
     * @param int $id Identificador de la actividad.
     * @return actividadDTO|null Retorna el objeto actividadDTO si se encuentra, o null si no existe.
     */
    public function getActividadById($id);

    public function obtenerActSinDirigir($limit, $offset);

    public function obtenerActSinCompletar($limit, $offset);

    public function annadirusuario($id_actividad);

    public function annadirVoluntario($id_actividad);

    public function borrarUsuario($id_actividad);

    public function borrarVoluntario($id_actividad);

    public function nombreVoluntario($id_actividad);

    public function estaDirigida($id_actividad);
    public function actividadesFecha($desde, $hasta, $texto, $tipos, $usuario);

}

?>
