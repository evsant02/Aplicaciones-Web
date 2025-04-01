<?php
require_once("includes/config.php");
include __DIR__ . "/../comun/formBase.php";
require_once( __DIR__ . "/../actividad/actividadAppService.php");
require_once( __DIR__ . "/../actividades-usuario/actividadesusuarioAppService.php");
//include 'Actividad.php';

class reservarActividad
{
    private $actividad;

    public function __construct($actividad = null) {
        $this->actividad = $actividad;
    }
    
    

    // Método que construye el formulario de detalles y la funcionalidad de reserva
    public function Inicializacion(){

        $app = application::getInstance();
        $user = $app->getUserDTO();
        $actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();
        $actividadAppService = actividadAppService::GetSingleton();

        echo '<link rel="stylesheet" type="text/css" href="CSS/estiloActividad.css">';  //uso del css que da estilo a la actividad


        if ($this->actividad == null) {
            return "<p>Actividad no encontrada.</p>";
        }


        $html = <<<EOF
        <div class="actividad">
            <div class="actividad-img">
                <img src="img/{$this->actividad->foto()}" alt="Imagen de la actividad">
            </div>
            <div class="actividad-detalles">
                <h1>{$this->actividad->nombre()}</h1>
                <p><strong>Descripción:</strong> {$this->actividad->descripcion()}</p>
                <p><strong>Ubicación:</strong> {$this->actividad->localizacion()}</p>
                <p><strong>Fecha y hora:</strong> {$this->actividad->fecha_hora()}</p>
                <p><strong>Dirigido por:</strong> {$this->actividad->dirigida()}</p>
                <p><strong>Aforo:</strong> {$this->actividad->aforo()}</p>
                <p><strong>Plazas ya reservadas:</strong> {$this->actividad->ocupacion()}</p>
            
        
        EOF;


        if (!$actividadUsuarioAppService->isRegistrado($user->id(), $this->actividad->id())) {        
            // Reserva  (si el usuario no está registrado)
            // Mostrar formulario de reserva si hay plazas disponibles
            $html .= '<form method="post">'; 
            $html .= '<button type="submit" name="reservar">Reservar mi plaza</button>';
            $html .= '</form>';
        // Mostrar mensaje de reserva realizada si el formulario ha sido enviado
            if (isset($_POST['reservar'])) {
                $html .= $this->procesarReserva($user->id()); // Llamamos a la función de reserva
            }
        }
        else {
            $html .= '<form method="post">';  
            $html .= '<input type="hidden" name="id" value="' . $this->actividad->id() . '">';
            $html .= '<button type="submit" name="bajaActividad">Darse de baja</button>';
            $html .= '</form>';

            if (isset($_POST['bajaActividad'])) {
                $html .= $this->bajaActividad(); // Llamamos a la función de darse de baja
            }
        }

               
       // $html .= "</div></div>"; 
        return $html;
    }

    // Procesar la reserva de la actividad
    private function procesarReserva($id_usuario)    {
        
        $actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();
        $actividadAppService = actividadAppService::GetSingleton();
        $actividadAppService->annadirusuario($this->actividad->id());
        $actividadUsuarioAppService->apuntarUsuario($this->actividad->id(), $id_usuario);

        // Recargar la página
        header("Location: ".$_SERVER['REQUEST_URI']);
        exit(); 

        return '<p>¡Reserva realizada con éxito!</p>';
    }

}
?>
