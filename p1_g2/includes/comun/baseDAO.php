<?php

// Clase abstracta baseDAO, que proporciona métodos comunes para interactuar con la base de datos.
abstract class baseDAO 
{
    // Constructor vacío, utilizado en las clases que hereden de baseDAO.
    public function __construct()
    {
    }     

    // Método para escapar cadenas de texto y evitar inyecciones SQL.
    protected function realEscapeString($field)
    {
        // Obtiene la conexión a la base de datos desde la aplicación.
        $conn = application::getInstance()->getConexionBd();

        // Devuelve la cadena escapada para ser segura en la base de datos.
        return $conn->real_escape_string($field);
    }

    // Método para ejecutar una consulta SELECT y devolver los resultados.
    protected function ExecuteQuery($sql)
    {
        // Verifica que la consulta no esté vacía.
        if($sql != "")
        {
            // Obtiene la conexión a la base de datos.
            $conn = application::getInstance()->getConexionBd();

            // Ejecuta la consulta.
            $rs = $conn->query($sql);

            // Array para almacenar los resultados de la consulta.
            $tablaDatos = array();
            
            // Recorre cada fila del resultado y la añade al array.
            while ($fila = $rs->fetch_assoc())
            {  
                array_push($tablaDatos, $fila);
            }
                
            // Devuelve los resultados de la consulta.
            return $tablaDatos;
        } 
        else
        {
            return false;
        }
    }

    // Método para ejecutar una consulta de tipo INSERT, UPDATE o DELETE.
    protected function ExecuteCommand($sql)
    {
        // Verifica que la consulta no esté vacía.
        if($sql != "")
        {
            // Obtiene la conexión a la base de datos.
            $conn = application::getInstance()->getConexionBd();

            // Ejecuta la consulta y verifica si se ejecutó correctamente.
            if ( $conn->query($sql))
            {
                return $conn;
            }
        }

        // Si no se pudo ejecutar la consulta, retorna false.
        return false;
    }
}

?>
