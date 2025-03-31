<?php

/**
 * Interfaz IActividad
 * Define los métodos necesarios para la gestión de actividades en el sistema.
 */
interface IActividadesusuario
{
    /**
     * Crea una nueva actividad en el sistema.
     * @param actividadesusuarioDTO $actividaddesusuarioDTO Objeto que contiene los datos de la actividad a crear.
     * @return actividadesusuarioDTO|null Retorna el objeto creado o null si hubo un error.
     */
    public function crear($actividadesusuarioDTO);

    /**
     * Elimina una actividad existente.
     * @param $actividadesusuarioDTO $esus$actividadesusuarioDTO Objeto que representa la actividad a eliminar.
     * @return bool Retorna true si la eliminación fue exitosa, false en caso contrario.
     */
    public function eliminar($actividadesusuarioDTO);

    /**
     * Modifica los datos de una actividad existente.
     * @param $actividadesusuarioDTO $esus$actividadesusuarioDTO Objeto con los nuevos datos de la actividad.
     * @return bool Retorna true si la modificación fue exitosa, false en caso contrario.
     */
    public function obtenerTodasLasActividades();

    /**
     * Obtiene una actividad específica a partir de su ID.
     * @param int $id Identificador de la actividad.
     * @return actividadesusuarioDTO|null Retorna el objeto esus$actividadesusuarioDTO si se encuentra, o null si no existe.
     */
}

?>
