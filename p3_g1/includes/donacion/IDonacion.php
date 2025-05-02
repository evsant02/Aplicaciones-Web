<?php
namespace includes\donacion;

/**
 * Interfaz IActividad
 * Define los métodos necesarios para la gestión de donaciones en el sistema.
 */
interface IDonacion
{
    /**
     * Crea una nueva donacion en el sistema.
     * @param donacionDTO $donacionDTO Objeto que contiene los datos de la donacion a crear.
     * @return donacionDTO|null Retorna el objeto creado o null si hubo un error.
     */
    public function crear($donacionDTO);

    /**
     * Obtiene todas las donaciones almacenadas en el sistema.
     * @return array Retorna un array de objetos donacionDTO con todas las donaciones.
     */
    public function obtenerTodasLasDonaciones();

    public function getEstadisticasDonaciones();

    public function getDonacionesPorMes();

}

?>
