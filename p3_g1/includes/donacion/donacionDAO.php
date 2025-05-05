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
            $esccantidad = $this->realEscapeString($donacionDTO->cantidad());
            $escfecha = $this->realEscapeString($donacionDTO->fecha());

            // Consulta SQL para insertar una nueva actividad
            $query = "INSERT INTO donaciones (cantidad, fecha) VALUES (?, ?)";
            $stmt = $conn->prepare($query);

            // Se vinculan los parámetros de la consulta
            $stmt->bind_param("ds", 
                $esccantidad,
                $escfecha
            );

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el ID generado por la inserción
                $idDonacion = $conn->insert_id;
                return new donacionDTO($idDonacion, $esccantidad, strtotime($escfecha));
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
            $query = "SELECT id_donacion, cantidad, fecha FROM donaciones";
            $stmt = $conn->prepare($query);

            // Se ejecuta la consulta
            $stmt->execute();
            $stmt->bind_result($id_donacion, $cantidad, $fecha);

            $donaciones = [];
            while ($stmt->fetch()) {
                $donaciones[] = new donacionDTO($id_donacion, $cantidad, $fecha);
            }

            return $donaciones;

        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }   

    public function getEstadisticasDonaciones(){

        $donaciones = $this->obtenerTodasLasDonaciones();
        $porMes = $this->getDonacionesPorMes();
        
        // Calcular totales
        $totales = ['total' => 0, 'ultimoMes' => 0, 'ultimoTrimestre' => 0];
        $fechaMes = (new \DateTime())->modify('-1 month');
        $fechaTrimestre = (new \DateTime())->modify('-3 months');
        
        foreach ($donaciones as $donacion) {
            $totales['total'] += $donacion->cantidad();
            
            $fechaDonacion = new \DateTime($donacion->fecha());
            if ($fechaDonacion >= $fechaMes) {
                $totales['ultimoMes'] += $donacion->cantidad();
            }
            if ($fechaDonacion >= $fechaTrimestre) {
                $totales['ultimoTrimestre'] += $donacion->cantidad();
            }
        }
        
        // Preparar datos para el gráfico
        $datosGrafico = array_fill(0, 12, 0);
        foreach ($porMes as $dato) {
            if ($dato['año'] == date('Y')) {
                $datosGrafico[$dato['mes'] - 1] = $dato['total'];
            }
        }
        
        return [
            'total' => number_format($totales['total'], 2),
            'ultimoMes' => number_format($totales['ultimoMes'], 2),
            'ultimoTrimestre' => number_format($totales['ultimoTrimestre'], 2),
            'totalDonaciones' => count($donaciones),
            'datosGrafico' => $datosGrafico
        ];
    }

    public function getDonacionesPorMes()
    {
        $stmt = null;
        try {
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener donaciones agrupadas por mes
            $query = "SELECT 
                        YEAR(fecha) as año, 
                        MONTH(fecha) as mes, 
                        SUM(cantidad) as total_mes,
                        COUNT(id_donacion) as cantidad_donaciones
                    FROM donaciones 
                    GROUP BY YEAR(fecha), MONTH(fecha)
                    ORDER BY año ASC, mes ASC";

            $stmt = $conn->prepare($query);
            
            if (!$stmt) {
                throw new \RuntimeException("Error al preparar la consulta: " . $conn->error);
            }

            // Se ejecuta la consulta
            $stmt->execute();
            $stmt->bind_result($año, $mes, $total_mes, $cantidad_donaciones);

            $datosPorMes = [];
            while ($stmt->fetch()) {
                $datosPorMes[] = [
                    'año' => $año,
                    'mes' => $mes,
                    'total' => $total_mes,
                    'cantidad_donaciones' => $cantidad_donaciones
                ];
            }

            return $datosPorMes;

        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }
   
}
?>