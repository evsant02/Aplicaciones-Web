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

        if($user->tipo()==1){
            $html .= "<p> <em> Usuario </em> </p>"; // si no es admin. se mostrarian las actividades programadas
        }else if($user->tipo()==2){
            $html .= "<p> <em> Voluntario </em> </p>"; // si no es admin. se mostrarian las actividades programadas
        }
        
        $html .= '<h3><em>Tus Actividades:</em></h3>';

        $actividadesPerfil = new actividadesPerfil(); //devuelve las actividades de ese usuario
        $htmlListado = $actividadesPerfil->generarListadoPerfil();

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
