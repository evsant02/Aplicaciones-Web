<?php
//incluir esto para que podamos trabajar con los metodos
require_once("includes/actividades-usuario/actividadesusuarioAppService.php");
require_once("includes/actividad/actividadAppService.php");
<<<<<<< HEAD
=======
require_once("includes/usuario/userAppService.php");

// Incluir la configuración general del sistema
require_once("includes/config.php");
// Incluir la clase que genera la lista de actividades disponibles
require_once("includes/mostrarPerfil/actividadesPerfil.php");
>>>>>>> main

function mostrarPerfil(): string {
    $user = application::getInstance()->getUserDTO(); // se obtienen los datos del usuario
    $html = null;


    if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) {
        $html .= "<h2><p> <em>Bienvenid@, " . $user->nombre() . "</em> " . $user->apellidos() . "</p></h2>";
        $html .= "<p> " . $user->correo() . " | " . $user->fecha_nacimiento() . "</p>";
    }
    $html .= '<hr/>';
   
    if (application::getInstance()->soyAdmin()) { // si es administrador
        $html .= "<p> <em> Administrador </em> </p>";
        $html .= '<a href="CrearActividad.php"><button>Crear actividad</button></a>';
        $html .= '<a href="vistaActividades.php"><button>Modificar actividad</button></a>'; // se muestran los botones para gestionar las actividades
      } else {
        $html .= "<p> <em> Usuario/Voluntario </em> </p>"; // si no es admin. se mostrarian las actividades programadas
        $html .= '<p><em>Tus Actividades.</em></p>';

        $actividadesPerfil = new actividadesPerfil(); //devuelve las actividades de ese usuario
        $htmlListado = $actividadesPerfil->generarListadoPerfil();

        $html .= $htmlListado; 

<<<<<<< HEAD
        //el metodo creado en user
        $userAppService = userAppService::GetSingleton();
        $idsActividades = $userAppService->getActividadesUsuario($user->id());


        if (!empty($idsActividades)) {
            $html .= '<div class="actividades-container">';
            $html .= '<h3>Tus actividades reservadas:</h3>';
            $html .= '<div class="actividades-grid">';
           
            $actividadAppService = actividadAppService::GetSingleton();
           
            foreach ($idsActividades as $idActividad) {
                try {
                    $actividad = $actividadAppService->getActividadById($idActividad);
                   
                    $html .= '<div class="actividad-card">';
                    $html .= '<img src="' . htmlspecialchars($actividad->foto()) . '" alt="' . htmlspecialchars($actividad->nombre()) . '">';
                    $html .= '<div class="actividad-details">';
                    $html .= '<h4>' . htmlspecialchars($actividad->nombre()) . '</h4>';
                    $html .= '<p>' . date('d/m/Y H:i', strtotime($actividad->fecha_hora())) . '</p>';
                    $html .= '</div></div>';
                   
                } catch (Exception $e) {
                    error_log("Error al obtener actividad ID $idActividad: " . $e->getMessage());
                    continue;
                }
            }
           
            $html .= '</div></div>'; // Cierre de actividades-grid y actividades-container
        } else {
            $html .= '<p class="no-actividades">No tienes actividades reservadas actualmente.</p>';
        }
=======
>>>>>>> main
    }
    return $html;
}

?>

<?php
require_once("includes/config.php");


$tituloPagina = 'Mi perfil - Conecta65';
$contenidoPrincipal = mostrarPerfil();
require("includes/comun/plantilla.php");
?>
