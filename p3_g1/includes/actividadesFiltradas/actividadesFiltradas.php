<?php

namespace includes\actividadesFiltradas;

use includes\application;
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

        //comprobacion de si el usuario introduce un inicio o final, incluya todo el rango
        if ((!empty($_GET['inicio']) && empty($_GET['final'])) ||(empty($_GET['inicio']) && !empty($_GET['final']) )) {
            return '<p>Seleccione un rango completo de fechas para filtrar</p>';
        }
        $desde = $_GET['inicio'] ?? null;
        $hasta = $_GET['final'] ?? null;
        //comprobacion validez de fechas
        if($desde>$hasta){
            return '<p>La fecha de inicio no puede ser posterior a la de final del intervalo</p>';
        }
        //escape del texto introducido por el usuario
        $texto = htmlspecialchars(trim($_GET['texto'] ?? ''), ENT_QUOTES, 'UTF-8');
        $tipos = $_GET['tipos'] ?? '';
        $actividadAppService = actividadAppService::GetSingleton();
        
        $app = application::getInstance();

        $userId = $app->getUserDTO()->tipo();
        //obtiene el array de actividades
        $this->actividades = $actividadAppService->actividadesFiltrar($desde, $hasta, $texto, $tipos, $userId);
        echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';
        
        $html = '';

        if($this->actividades == null) {
            $html =  '<p>¡No se han encontrado actividades con esos parámetros!</p> 
            <div class="sin-actividades">
                <div class="imagen-centrada">
                    <img src="img/logo.jpeg" alt="Logo de la organización" class="logo-actividades">
                </div>
            </div>';
        }
        else {
            //muestras las actividades
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
                $html .= '<p>' . $fechaHora->format('d-m-Y H:i') . '</p>'; // Formato: día-mes-año hora:minutos

                $html .= '<p>Aforo: ' . $actividad->ocupacion(). '/' . $actividad->aforo() . '</p>';
                if ($app->soyAdmin()){
                    $html .= '<a href="ModificarActividad.php?id=' . $actividad->id() . '"><button type="button">Modificar</button></a> ';
                    $html .= '<a href="EliminarActividad.php?id=' . $actividad->id() . '"><button type="button">Eliminar</button></a>';
                }
                $html .= '</div>'; // actividad
                $html .= '</div>'; // actividad-item
            }   
        }
        
        return $html;
    }

}