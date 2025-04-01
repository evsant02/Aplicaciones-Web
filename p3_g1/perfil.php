<?php
//incluir esto para que podamos trabajar con los metodos
require_once("includes/actividades-usuario/actividadesusuarioAppService.php");
require_once("includes/actividad/actividadAppService.php");
require_once("includes/usuario/userAppService.php");

// Incluir la configuración general del sistema
require_once("includes/config.php");
// Incluir la clase que genera la lista de actividades disponibles
require_once("includes/mostrarPerfil/actividadesPerfil.php");

function mostrarPerfil(): string {
    $app = application::getInstance();
    $user = $app->getUserDTO(); // se obtienen los datos del usuario
    $html = null;


    if ($app->isSessionSet()) {
        $html .= "<h2><p> <em>Bienvenid@, " . $user->nombre() . "</em> " . $user->apellidos() . "</p></h2>";
        $html .= "<p> " . $user->correo() . " | " . $user->fecha_nacimiento() . "</p>";
    }
    $html .= '<hr/>';
   
    if ($app->soyAdmin()) { // si es administrador
        $html .= "<p> <em> Administrador </em> </p>";
        $html .= '<a href="CrearActividad.php"><button>Crear actividad</button></a>';
        $html .= '<a href="vistaActividades.php"><button>Modificar actividad</button></a>'; // se muestran los botones para gestionar las actividades
      } else {
        if($app->soyUsuario()) $html .= "<p> <em> Usuario </em> </p>"; // se muestra el tipo de usuario
        else if ($app->soyVoluntario())$html .= "<p> <em> Voluntario </em> </p>";
        $html .= '<p><h2>Tus próximas actividades</h2></p>'; 

        $actividadesPerfil = new actividadesPerfil(); //devuelve las actividades de ese usuario
        $htmlListado = $actividadesPerfil->generarListadoPerfil();  // se muestran las actividades

        $html .= $htmlListado; 

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
