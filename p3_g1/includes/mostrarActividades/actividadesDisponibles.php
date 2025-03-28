<?php
include __DIR__ . "/../comun/formBase.php";
include 'Actividad.php';

//ESTA CLASE NO HACE USO DE LA BBDD DE MOMENTO (se simula la obtencion de datos)
class actividadesDisponibles extends formBase
{
    private $actividades;

    public function __construct() 
    {
        parent::__construct('actividadesDisponibles');
        $this->actividades = $this->obtenerActividades();
    }

    //al no hacer uso de la bbdd se simulan las actividades aqui
    private function obtenerActividades(){
        return [
            new Actividad(1, "Clase de Baile", "baile.jpg", "Disfruta bailando al ritmo de la música.", true, "Centro Cultural", "2025-03-10 18:00", "María López", 20),
            new Actividad(2, "Taller de Costura", "costura.jpg", "Aprende a coser tus propias prendas.", false, "Casa de la Cultura", "2025-03-12 16:00", null, 10),
            new Actividad(3, "Taller de Informática", "informatica.jpg", "Iníciate en el mundo de la informática.", true, "Biblioteca Municipal", "2025-03-15 10:00", "Pedro Sánchez", 8),
            new Actividad(4, "Huerto Urbano", "huerto.jpg", "Crea un huerto urbano en tu comunidad.", true, "Parque Central", "2025-03-18 09:00", "Lucía Gómez", 15),
            new Actividad(5, "Cocina Saludable", "cocina.jpg", "Recetas fáciles para una vida más saludable.", false, "Centro de Mayores", "2025-03-20 11:00", null, 5),
            new Actividad(6, "Manualidades", "manualidades.jpg", "Apúntate para exprimir al máximo tu creatividad.", true, "Asociación Vecinal", "2025-03-22 15:00", "Ana Rodríguez", 10),
            new Actividad(7, "Club de Lectura", "lectura.jpg", "Comparte con otras personas tus opiniones sobre la lectura propuesta cada mes.", true, "Librería El Rincón", "2025-03-25 17:30", "Carlos Pérez", 20),
            new Actividad(8, "Excursión al Palacio Real", "excursionPR.jpg", "Apúntate a visitar uno de los lugares más turísticos de Madrid.", true, "Palacio Real", "2025-03-28 08:00", "Sofía Fernández", 15),
            new Actividad(9, "Visitar al Teatro Real", "excursionTR.jpg", "Visita el Teatro Real por dentro como nunca antes lo habias visto.", false, "Teatro Real", "2025-05-28 11:00", null, 10),
        ];
    }

    protected function CreateFields($datos){

        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';  //uso del css que da estilo a la tabla de las actividades
        


        $tipo_usuario = isset($_GET['tipo']) ? $_GET['tipo'] : 'usuario'; //obtencion del tipo de usuario para que se muestren unas actividades u otras. se puede cambiar para probar

        $html = '<table><tr>';
        $colCount = 0;

        //se recorren las actividades para mostrarlas en un formato de tabla
        foreach ($this->actividades as $actividad) {
            if (($tipo_usuario == 'usuario' && $actividad->getDirigida()) ||
                ($tipo_usuario == 'voluntario' && !$actividad->getDirigida())) {
                
                if ($colCount > 0 && $colCount %  3== 0) {
                    $html .= '</tr><tr>'; //nueva fila después de 4 celdas
                }
                $colCount++;
                
                $html .= '<td>' . $actividad->mostrar($tipo_usuario) . '</td>'; //metodo de la clase actividad que muestra la actividad
            }
        }
        
        $html .= '</tr></table>';
        return $html;
    }

  

    /*protected function CreateFields($datos) {
        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';  //uso del css que da estilo a la tabla de las actividades
    
        $tipo_usuario = isset($_GET['tipo']) ? $_GET['tipo'] : 'usuario'; //obtencion del tipo de usuario para que se muestren unas actividades u otras. se puede cambiar para probar
    
        $html = '<table class="tabla-actividades"><tr>';
        $colCount = 0;
    
        //se recorren las actividades para mostrarlas en un formato de tabla
        foreach ($this->actividades as $actividad) {
            if (($tipo_usuario == 'usuario' && $actividad->getDirigida()) ||
                ($tipo_usuario == 'voluntario' && !$actividad->getDirigida())) {
                
                $html .= '<td>' . $actividad->mostrar($tipo_usuario) . '</td>'; //metodo de la clase actividad que muestra la actividad
                $colCount++;
            }
        }
    
        $html .= '</tr></table>';
        return $html;
    }*/





    /*protected function CreateFields($datos) {
        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';
        
        $tipo_usuario = isset($_GET['tipo']) ? $_GET['tipo'] : 'usuario'; 
        
        $html = '<table class="tabla-actividades">';
        
        foreach ($this->actividades as $actividad) {
            if (($tipo_usuario == 'usuario' && $actividad->getDirigida()) ||
                ($tipo_usuario == 'voluntario' && !$actividad->getDirigida())) {
                    
                $html .= '<tr>';
                $html .= '<td>' . $actividad->mostrar($tipo_usuario) . '</td>'; // Muestra la actividad completa en una celda
                $html .= '</tr>';
            }
        }
        
        $html .= '</table>';
        return $html;
    }*/

    protected function Process($datos)
    {
        return [];
    }
}
?>



