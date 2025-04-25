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
        $this->actividades = null; 
    }

     

    public function Inicializacion(){

        $actividadAppService = actividadAppService::GetSingleton();
        //obtengo las actividades segun el tipo de usuario
        $this->actividades = $actividadAppService->obtenerActividadSegunUsuario(); 


        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';  
        
        $html = '<div class="tabla-actividades">'; // Changed from table to div
        
        
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