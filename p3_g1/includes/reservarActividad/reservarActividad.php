<?php
require_once("includes/config.php");
include __DIR__ . "/../comun/formBase.php";
//include 'Actividad.php';

class reservarActividad extends formBase
{
    private $actividad;

    public function __construct($actividad = null) {
        parent::__construct('reservaActividad');
        $this->actividad = $actividad;
    }
    
    
    //simulación de obtener la actividad simulada (en un futuro se usará la BBDD)
    /*
    private function obtenerActividad(){

        //$id = isset($_GET['id']) ? $_GET['id'] : null;

        $id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);

        // Verificar si el ID se recibió correctamente
        
        //verificar si el ID está en la URL
        //echo "<p>ID recibido: $id</p>"; // Depuración

        if (!$id) return null;

        //ACTIVIDADES
        $actividades = [
            new Actividad(1, "Clase de Baile", "baile.jpg", "Disfruta bailando al ritmo de la música.", true, "Centro Cultural", "2025-03-10 18:00", "María López", 20),
            new Actividad(2, "Taller de Costura", "costura.jpg", "Aprende a coser tus propias prendas.", false, "Casa de la Cultura", "2025-03-12 16:00", null, 10),
            new Actividad(3, "Taller de Informática", "informatica.jpg", "Iníciate en el mundo de la informática.", true, "Biblioteca Municipal", "2025-03-15 10:00", "Pedro Sánchez", 8),
            new Actividad(4, "Huerto Urbano", "huerto.jpg", "Crea un huerto urbano en tu comunidad.", true, "Parque Central", "2025-03-18 09:00", "Lucía Gómez", 15),
            new Actividad(5, "Cocina Saludable", "cocina.jpg", "Recetas fáciles para una vida más saludable.", false, "Centro de Mayores", "2025-03-20 11:00", null, 5),
            new Actividad(6, "Manualidades", "manualidades.jpg", "Apúntate para exprimir al máximo tu creatividad.", true, "Asociación Vecinal", "2025-03-22 15:00", "Ana Rodríguez", 10),
            new Actividad(7, "Club de Lectura", "lectura.jpg", "Comparte con otras personas tus opiniones sobre la lectura propuesta cada mes.", true, "Librería El Rincón", "2025-03-25 17:30", "Carlos Pérez", 20),
            new Actividad(8, "Excursión al Palacio Real", "excursionPR.jpg", "Apúntate a visitar uno de los lugares más turísticos de Madrid.", true, "Palacio Real", "2025-03-28 08:00", "Sofía Fernández", 15),
            new Actividad(9, "Visitar al Teatro Real", "excursionTR.jpg", "Visita el Teatro Real por dentro como nunca antes lo habias visto.", false, "Teatro Real", "2025-05-28 11:00", null, 10),
        ];

        foreach ($actividades as $act) { //devuelvo la act cuyo id se corresponde al seleccionado
            if ($act->getId() == $id) {
                return $act;
            }
        }

        return null;
    }
    */

    // Método que construye el formulario de detalles y la funcionalidad de reserva
    protected function CreateFields($datos){

        $app = application::getInstance();
        $user = $app->getUserDTO();
        $actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();

        echo '<link rel="stylesheet" type="text/css" href="CSS/estiloActividad.css">';  //uso del css que da estilo a la actividad


        if ($this->actividad == null) {
            return "<p>Actividad no encontrada.</p>";
        }


        $html = <<<EOF
        <div class="actividad">
            <div class="actividad-img">
                <img src="img/{$this->actividad->getImagen()}" alt="Imagen de la actividad">
            </div>
            <div class="actividad-detalles">
                <h1>{$this->actividad->getTitulo()}</h1>
                <p><strong>Descripción:</strong> {$this->actividad->getDescripcion()}</p>
                <p><strong>Ubicación:</strong> {$this->actividad->getUbicacion()}</p>
                <p><strong>Fecha y hora:</strong> {$this->actividad->getFecha()}</p>
                <p><strong>Dirigido por:</strong> {$this->actividad->getVoluntario()}</p>
                <p><strong>Plazas disponibles:</strong> {$this->actividad->getPlazas()}</p>
            
        
        EOF;


        if (!$actividadUsuarioAppService->isRegistrado($user->id(), $this->$actividad->getId())) {        
            // Reserva  (si el usuario no está registrado)
            // Mostrar formulario de reserva si hay plazas disponibles
            if ($this->actividad->getPlazas() > 0) {
                $html .= '<form method="post">';  
                $html .= '<input type="hidden" name="id" value="' . $this->actividad->getId() . '">';
                $html .= '<button type="submit" name="reservar">Reservar mi plaza</button>';
                $html .= '</form>';
            } else {
                $html .= '<p>No hay plazas disponibles</p>';
            }

        // Mostrar mensaje de reserva realizada si el formulario ha sido enviado
            if (isset($_POST['reservar'])) {
                $html .= $this->procesarReserva(); // Llamamos a la función de reserva
            }
        }
        else {
            $html .= '<form method="post">';  
            $html .= '<input type="hidden" name="id" value="' . $this->actividad->getId() . '">';
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
    private function procesarReserva()
    {
        return '<p>¡Reserva realizada con éxito!</p>';
    }


    protected function Process($datos)
    {
        return [];
    }
}
?>
