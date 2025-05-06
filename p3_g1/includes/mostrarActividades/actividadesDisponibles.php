<?php

namespace includes\mostrarActividades;

use includes\actividad\actividadAppService;
use includes\application;

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
        $app = application::getInstance();


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
                $html .= '<div class="actividad-item">';
                
                $html .= '<div class="actividad">';

                if ($app->soyUsuario()) {
                    $html .= '<a href="vistaReservaActividad.php?id=' . $actividad->id() . '" class="imagen-enlace">';
                }
                else if ($app->soyVoluntario()) {
                    $html .= '<a href="vistaDirigirActividad.php?id=' . $actividad->id() . '" class="imagen-enlace">';
                }
                $html .= '<img src="' . $actividad->foto().  '" alt="' . $actividad->nombre() . '" width="350">';
                if (!$app->soyAdmin()) $html .= '</a>';
                $html .= '<h3>' . $actividad->nombre() . '</h3>';
        
                $fechaHora = new \DateTime($actividad->fecha_hora());
                $html .= '<p>' . $fechaHora->format('d-m-Y H:i') . '</p>'; 
        
                $html .= '<p>Aforo: ' . $actividad->ocupacion(). '/' . $actividad->aforo() . '</p>';
                
                $html .= '</div>';
                // . $actividadAppService->mostrar($actividad) . '</div>';    
                $html .= '</div>';
            }   
        }
        
        $html .= '</div>'; // Close the flex container
        
        return $html;
    }
}