<?php
namespace includes\donacion;

// Definición de la clase donacionDTO para representar donaciones
class donacionDTO
{
    // Atributos privados para evitar acceso directo
    private $id_donacion;
    private $cantidad;

    // Constructor para inicializar una donacion con sus datos
    public function __construct($id_donacion, $cantidad)
    {
        $this->id_donacion = $id_donacion;
        $this->cantidad = $cantidad;
    }

    // Métodos públicos para obtener los valores de los atributos

    // Devuelve el ID de la donacion
    public function id_donacion()
    {
        return $this->id_donacion;
    }

    // Devuelve la cantidad de la donacion
    public function cantidad()
    {
        return $this->cantidad;
    }
}
?>
