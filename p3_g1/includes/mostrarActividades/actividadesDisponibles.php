<?php
include 'Actividad.php';

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
        $user = application::getInstance()->getUserDTO();
        $tipo_user = $user->tipo();
        var_dump($tipo_user);
        //$html = '<table><tr>';
        //habia que poner el nommbre para que lo pillara
        $html = '<table class="tabla-actividades"><tr>'; //PRUEBA

        $colCount = 0;

        foreach ($this->actividades as $actividad) {       
                
                if ($colCount > 0 && $colCount % 3 == 0) {
                    $html .= '</tr><tr>'; 
                }
                $colCount++;
                
                $html .= '<td>' . $actividad->mostrar($actividad,$tipo_user) . '</td>';             
        }
        
        $html .= '</tr></table>';
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


    //muestra las actividades HTML 
    public function mostrar($actividad, $tipo_usuario) {
        $user = application::getInstance()->getUserDTO();
        $tipo_user = $user->tipo();
        $html = '<div class="actividad">';
        $html .= '<img src="img/' . $actividad->imagen . '" alt="' . $actividad->titulo . '">';
        $html .= '<h3>' . $actividad->titulo . '</h3>';
        $html .= '<p class="descripcion">' . $actividad->descripcion . '</p>';
        //usuario
        if ($tipo_user == 1){            
            $html .= '<a href="vistaReservaActividad.php?id=' . $actividad->id . '" class="btn">Reservar</a>';

        }
        //voluntario
        if ($tipo_user == 2){
            $html .= '<a href="vistaDirigirActividad.php?id=' . $actividad->id . '" class="btn">Dirigir</a>';

        }
        //administrador: dos botones
        if ($tipo_user == 0){
            //debe de aparecer un boton para eliminarla y otro para modificar los datos
            $html .= '<a href="ModificarActividad.php?id=' . $actividad->id . '" class="btn">Modificar</a>';
            $html .= '<a href="EliminarActividad.php?id=' . $actividad->id . '" class="btn">Eliminar</a>';
        }
        //$html .= '<a href="' . $this->getEnlace($tipo_usuario) . '" class="btn">' . ($tipo_usuario == 'usuario' ? 'Inscribirse' : 'Dirigir') . '</a>';
        
        $html .= '</div>';
        return $html;  //se devuelve en html
    }










}



