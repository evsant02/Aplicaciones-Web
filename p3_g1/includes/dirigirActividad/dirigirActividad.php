<?php
//include __DIR__ . "/../comun/formBase.php";
require_once("includes/config.php");
require_once( __DIR__ . "/../actividad/actividadAppService.php");
require_once( __DIR__ . "/../actividades-usuario/actividadesusuarioAppService.php");
//include 'Actividad.php';

class dirigirActividad 
{
    private $actividad;

    public function __construct($actividad = null) {
        $this->actividad = $actividad;
    }

    //simulación de obtener la actividad simulada (en un futuro se usará la BBDD)
    /*private function obtenerActividad()
    {
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

        //$id = isset($_GET['id']) ? $_GET['id'] : null;
        $id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);
        foreach ($actividades as $act) {
            if ($act->getId() == $id) {
                $this->actividad = $act;
                return;
            }
        }
        $this->actividad = null;
    }*/

    public function Inicializacion(){

        $app = application::getInstance();
        $user = $app->getUserDTO();
        $actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();
        $actividadAppService = actividadAppService::GetSingleton();

        echo '<link rel="stylesheet" type="text/css" href="CSS/estiloActividad.css">';  //uso del css que da estilo a la actividad


       
        if ($this->actividad == null) {
            return "<p>Actividad no encontrada.</p>";
        }

        $fechaHora = new DateTime($this->actividad->fecha_hora());

        $html = <<<EOF
        <div class="actividad">
            <div class="actividad-img">
                <img src="{$this->actividad->foto()}" alt="Imagen de la actividad">
            </div>
            <div class="actividad-detalles">
                <h1>{$this->actividad->nombre()}</h1>
                <p><strong>Descripción:</strong> {$this->actividad->descripcion()}</p>
                <p><strong>Ubicación:</strong> {$this->actividad->localizacion()}</p>
                <p><strong>Fecha y hora:</strong> {$fechaHora->format('d-m-Y H:i')}</p>
                <p><strong>Dirigido por:</strong> {$this->actividad->dirigida()}</p>
                <p><strong>Aforo:</strong> {$this->actividad->aforo()}</p>
                <p><strong>Plazas ya reservadas:</strong> {$this->actividad->ocupacion()}</p>
            
        
        EOF;

        $mensaje = null;


        if (!$actividadUsuarioAppService->isRegistrado($user->id(), $this->actividad->id())) {  
            // Reserva  (si el usuario no está registrado)
            // Mostrar formulario de reserva si hay plazas disponibles
            $html .= '<form method="post">';
            $html .= '<button type="submit" name="dirigir">Dirigir esta actividad</button>';
            $html .= '</form>';
        
            // Mostrar mensaje de reserva realizada si el formulario ha sido enviado
            if (isset($_POST['dirigir'])) {
                $mensaje = $this->procesarDirigir($user->id()); // Llamamos a la función de reserva
            }
    
        }
        else {
            $html .= '<form method="post">';  
            $html .= '<input type="hidden" name="id" value="' . $this->actividad->id() . '">';
            $html .= '<button type="submit" name="bajaDirigir">Darse de baja</button>';
            $html .= '</form>';

            if (isset($_POST['bajaDirigir'])) {
                $mensaje = $this->bajaDirigir($user->id()); // Llamamos a la función de darse de baja
            }
        }
        // Se redirige a la página principal con un mensaje de éxito

        // Se almacena un mensaje de éxito en la sesión para mostrarlo al usuario
        $app = application::getInstance();  

        $app->putAtributoPeticion('mensaje', $mensaje);


        return $html;
    }



    // Procesar la reserva de la actividad
    private function procesarDirigir($id_voluntario)    {
        
        $actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();
        $actividadAppService = actividadAppService::GetSingleton();
        $actividadAppService->annadirVoluntario($this->actividad->id());
        $actividadUsuarioAppService->apuntarUsuario($this->actividad->id(), $id_voluntario);

        $mensaje =  '<p>¡Ahora diriges esta actividad!</p>';
        // Recargar la página
        header("Location: ".$_SERVER['REQUEST_URI']);
        
        return $mensaje;
    }

    private function bajaDirigir($id_voluntario) {

        $actividadUsuarioAppService = actividadesusuarioAppService::GetSingleton();
        $actividadAppService = actividadAppService::GetSingleton();
        $actividadAppService->borrarVoluntario($this->actividad->id());
        $actividadUsuarioAppService->bajaUsuario($this->actividad->id(), $id_voluntario);

        $mensaje =  '<p>Se te ha dado de baja en la actividad.</p>';
        // Recargar la página
        header("Location: ".$_SERVER['REQUEST_URI']);
        //exit(); 

        return $mensaje;
    }


}
?>
