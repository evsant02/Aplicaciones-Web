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

        if ((!empty($_GET['inicio']) && empty($_GET['final'])) ||(empty($_GET['inicio']) && !empty($_GET['final']) )) {
            return '<p>Seleccione un rango completo de fechas para filtrar</p>';
        }
        $desde = $_GET['inicio'] ?? null;
        $hasta = $_GET['final'] ?? null;
        if($desde>$hasta){
            return '<p>La fecha de inicio no puede ser posterior a la de final del intervalo</p>';
        }
        $texto = htmlspecialchars(trim($_GET['texto'] ?? ''), ENT_QUOTES, 'UTF-8');
        $actividadAppService = actividadAppService::GetSingleton();
        $this->actividades = $actividadAppService->actividadesFecha($desde, $hasta, $texto); 

        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';  
        
        $html='';
        if($this->actividades == null) {
            $html =  '<p>¡No se han encontrado actividades con esos parámetros!</p> 
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