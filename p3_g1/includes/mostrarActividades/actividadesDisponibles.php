<?php

namespace includes\mostrarActividades;

use includes\actividad\actividadAppService;

//require_once( __DIR__ . "/../actividad/actividadAppService.php");

// Clase que gestiona la lista de actividades disponibles
class actividadesDisponibles 
{
    private $actividades;

    public function __construct() 
    {
        $this->actividades = $this->obtenerActividades();
    }

    // dependiendo del tipo de usuario se muestran diferentes actividades
    private function obtenerActividades(){
        $actividadAppService = actividadAppService::GetSingleton();
        $actividades = $actividadAppService->obtenerActividadSegunUsuario();
        return $actividades;        
    }

    /*public function generarListado()
    {
        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';  
        
        $html = '<table class="tabla-actividades"><tr>'; 
        $colCount = 0;
        $actividadAppService = actividadAppService::GetSingleton();
        if($this->actividades==null){
            $html =  '<p>¡Ya estas registrado a todas las actividades!</p> 
            <div class="sin-actividades">
                <div class="imagen-centrada">
                    <img src="img/logo.jpeg" alt="Logo de la organización" class="logo-actividades">
                </div>
            </div>';
        }
        else{
            foreach ($this->actividades as $actividad) {       
                if ($colCount > 0 && $colCount % 3 == 0) {
                    $html .= '</tr><tr>'; 
                }
                $colCount++;
                $html .= '<td>' . $actividadAppService->mostrar($actividad) . '</td>';    
            }   
        
        $html .= '</tr></table>';
        }
        return $html;
    }*/

    public function generarListado()
    {
        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';  
        
        $html = '<div class="tabla-actividades">'; // Changed from table to div
        
        $actividadAppService = actividadAppService::GetSingleton();
        
        if($this->actividades == null) {
            $html =  '<p>¡Ya estas registrado a todas las actividades!</p> 
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
        
        $html .= '</div>'; // Close the flex container
        
        return $html;
    }

    


}