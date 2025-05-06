<?php

namespace includes\actividadesFiltradas;

use includes\actividad\actividadAppService;


// Clase que gestiona la lista de actividades filtradas por fecha
class actividadesFiltradas
{
    private $actividades;

    public function __construct() 
    {
        $this->actividades = null; 
    }
    public function filtrado(){

        if (empty($_GET['inicio']) || empty($_GET['final']) || empty($_GET['texto'])) {
            return '<p>Seleccione un rango de fechas para filtrar o una palabra</p>';
        }
        $desde = $_GET['inicio'] ?? null;
        $hasta = $_GET['final'] ?? null;
        $texto = $_GET['texto'] ?? '';
        //terminar el filtrado
        $actividadAppService = actividadAppService::GetSingleton();
        $this->actividades = $actividadAppService->actividadesFecha($desde, $hasta); 

        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';  
        
        $html='';
        if($this->actividades == null) {
            $html =  '<p>¡No hay nada en esas fechas!</p> 
            <div class="sin-actividades">
                <div class="imagen-centrada">
                    <img src="img/logo.jpeg" alt="Logo de la organización" class="logo-actividades">
                </div>
            </div>';
        }
        else {
            foreach ($this->actividades as $actividad) {       
                $html .= '<div class="actividad-item">' . $actividadAppService->mostrar($actividad) . '</div>';    
            }   
        }
        
        return $html;
    }

    


}