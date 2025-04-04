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

    public function generarListado()
    {
        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';  
        //obtenemos el tipo de usuario que está en la sesion
        //$user = application::getInstance()->getUserDTO();
        //$tipo_user = $user->tipo();
        //habia que poner el nombre para que lo pillara
        $html = '<table class="tabla-actividades"><tr>'; //PRUEBA
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
    }

    // Método para obtener el enlace según el tipo de usuario
   /* public function getEnlace($tipo_usuario) {
        if ($tipo_usuario == 'usuario') {
            return "vistaReservaActividad.php?id=" . $this->id;
        } else {
            return "vistaDirigirActividad.php?id=" . $this->id;
        }
    }*/


}