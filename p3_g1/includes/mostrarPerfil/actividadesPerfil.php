<?php
namespace includes\mostrarPerfil;

use includes\actividad\actividadAppService;
use includes\actividadesusuario\actividadesusuarioAppService;
use includes\application;

class actividadesPerfil
{
    private $actividades;

    public function __construct() 
    {
        //esta devuelve las actividades correspondientes a ese usuario
        $this->actividades = $this->obtenerActividades();
    }


    private function obtenerActividades(){
        //el metodo para que me devuelva el id de las actividades de ese usuario
        //esto sirve para mandar el user->id
        $user = application::getInstance()->getUserDTO(); // se obtienen los datos del usuario
        $actividadesUsuarioService = actividadesusuarioAppService::GetSingleton();
        $actividadesUsuario = $actividadesUsuarioService->getActividadesUsuario($user->id());
        return $actividadesUsuario;        
    }

    public function generarListadoPerfil()
    {
        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';  

        // Verificar si no hay actividades
        if (empty($this->actividades)) {
            return '<p>No estás apuntado a ninguna actividad</p>';
        }
        
        $html = '<div class="tabla-actividades">'; 
        //$colCount = 0;

        $actividadAppService = actividadAppService::GetSingleton();
        $app = application::getInstance();

        //hay que llamar al metodo de getActividadByid

        //this->actividades nos devuelve las actividades de ese usuario

        foreach ($this->actividades as $actividad) {       // solo se deberian mostrar las futuras
            
            $actividad = $actividadAppService->getActividadById($actividad);

            $html .= '<div class="actividad-item">';
                
            $html .= '<div class="actividad">';

            if ($app->soyUsuario()) {
                $html .= '<a href="vistaReservaActividad.php?id=' . $actividad->id() . '" class="imagen-enlace"> 
                <img src="' . $actividad->foto() . '" alt="' . $actividad->nombre() . '" width="350"></a>';
            } else if ($app->soyVoluntario()) {
                $html .= '<a href="vistaDirigirActividad.php?id=' . $actividad->id() . '" class="imagen-enlace"> 
                <img src="' . $actividad->foto() . '" alt="' . $actividad->nombre() . '" width="350"></a>';
            }
    
            $html .= '<h3>' . $actividad->nombre() . '</h3>';
            
            // Formatear la fecha y hora
            $fechaHora = new \DateTime($actividad->fecha_hora());
            $html .= '<p>' . $fechaHora->format('d-m-Y H:i') . '</p>';

            $html .= '</div>';
            
            $html .= '</div>';
        }
        
        $html .= '</div>';
        return $html;
    }

}