<?php
namespace includes\mostrarPerfil;

use includes\actividad\actividadAppService;
use includes\actividadesusuario\actividadesusuarioAppService;
use includes\application;

//require_once( __DIR__ . "/../actividad/actividadAppService.php");
//require_once( __DIR__ . "/../actividades-usuario/actividadesusuarioAppService.php");
//require_once( __DIR__ . "/../usuario/userAppService.php");

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
        
        $html = '<table class="tabla-actividades"><tr>'; 
        $colCount = 0;

        $actividadAppService = actividadAppService::GetSingleton();

        //hay que llamar al metodo de getActividadByid

        //this->actividades nos devuelve las actividades de ese usuario

        foreach ($this->actividades as $actividad) {       // solo se deberian mostrar las futuras

                $actividadDTO = $actividadAppService->getActividadById($actividad);
                
                if ($colCount > 0 && $colCount % 3 == 0) {
                    $html .= '</tr><tr>'; 
                }
                $colCount++;

                $html .= '<td>' . $actividadAppService->mostrarPerfil($actividadDTO) . '</td>';
        }
        
        $html .= '</tr></table>';
        return $html;
    }


}