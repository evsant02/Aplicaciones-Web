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
    $user = $app->getUserDTO();
    $html = null;

    if ($app->isUserLogged()) {
        $html .= "<div class='perfil-contenedor'>";
        $html .= "<div class='perfil-header'>";
        $html .= "<h2><p> <em>Bienvenid@, " . $user->nombre() . "</em> " . $user->apellidos() . "</p></h2>";
        $html .= "<p> " . $user->correo() . " | " . $user->fecha_nacimiento() . "</p>";
       
    }
    $html .= '<hr/>';
    

    if ($app->soyAdmin()) {
        $html .= "<div class='perfil-admin'>";
        $html .= "<p class='rol-usuario'> <em> Administrador </em> </p>";
        $html .= "<div class='botones-admin'>";
        $html .= '<a href="CrearActividad.php"><button>Crear actividad</button></a>';
        $html .= '<a href="vistaActividades.php"><button>Modificar actividad</button></a>';
        $html .= "</div>"; // cierre botones-admin
        $html .= "</div>"; // cierre perfil-admin
    } else {
        $html .= "<div class='perfil-usuario'>";
        if($app->soyUsuario()) {
            $html .= "<p class='rol-usuario'> <em> Usuario </em> </p>";
            $html .= '<div class="linea-separadora-usuario"></div>'; // Línea añadida
        }
        else if ($app->soyVoluntario()) {
            $html .= "<p class='rol-usuario'> <em> Voluntario </em> </p>";
            $html .= '<div class="linea-separadora-usuario"></div>'; // Línea añadida
        }
        $html .= "</div>"; // cierre perfil-usuario
        $html .= "</div>"; // cierre perfil-header
        $html .= "</div>"; // cierre perfil-contenedor

        $html .= '<p><h3>Tus próximas actividades: </h3></p>'; 

        $actividadesPerfil = new actividadesPerfil();
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
