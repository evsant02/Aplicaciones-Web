<?php

interface IActividad
{
    public function eliminar($actividadDTO);

    public function modificar($actividadDTO);

    public function crear($actividadDTO);

    public function obtenerTodasLasActividades();

    public function getActividadById($id);

}
?>