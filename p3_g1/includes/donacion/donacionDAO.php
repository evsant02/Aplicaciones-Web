<?php
namespace includes\donacion;

use includes\comun\baseDAO;
use includes\application;
use includes\donacion\donacionDTO;

class donacionDAO extends baseDAO implements IDonacion
{
    // Constructor vacío
    public function __construct()
    {
    }

    // Método para crear una nueva donacion en la base de datos
    public function crear($donacionDTO)
    {
        try {

            // Obtener conexión con la base de datos
            $conn = application::getInstance()->getConexionBd();

            //escape de strings para evitar inyeccion sql
            $escIBAN = $this->realEscapeString($donacionDTO->IBAN());
            $esccantidad = $this->realEscapeString($donacionDTO->cantidad());

            // Consulta SQL para insertar una nueva actividad
            $query = "INSERT INTO donaciones (IBAN, cantidad) VALUES (?, ?)";
            $stmt = $conn->prepare($query);

            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("ii", 
                $escIBAN, 
                $esccantidad
            );

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el ID generado por la inserción
                $idDonacion = $conn->insert_id;
                return new donacionDTO($idDonacion, $escIBAN, $esccantidad);
            }
        } finally {
            if ($stmt) {
                $stmt->close(); // Asegura que el statement se cierra siempre
            }
        }
        return false;
    }

    // Método para obtener todas las donaciones almacenadas en la base de datos
    public function obtenerTodasLasDonaciones()
    {
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener todas las donaciones
            $query = "SELECT id_donacion, IBAN, cantidad FROM donaciones";
            $stmt = $conn->prepare($query);

            // Se ejecuta la consulta
            $stmt->execute();
            $stmt->bind_result($id_donacion, $IBAN, $cantidad);

            $donaciones = [];
            while ($stmt->fetch()) {
                $donaciones[] = new donacionDTO($id_donacion, $IBAN, $cantidad);
            }

            return $donaciones;

        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }    
   
}
?>