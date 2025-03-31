<?php
//incluir esto para que podamos trabajar con los metodos
require_once("includes/actividades-usuario/actividadesusuarioAppService.php");
require_once("includes/actividad/actividadAppService.php");
require_once("includes/usuario/userAppService.php");




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
        $html .= '<p><em>Aquí se mostrarán las actividades reservadas por el usuario/voluntario en la próxima práctica.</em></p>';


        //tener en cuenta como esta hecho actividadesDisponibles.php que usa un metodo en actividadusuarioAppservice mostrar

        //el metodo para que me devuelva el id de las actividades de ese usuario
        $userAppService = actividadesusuarioAppService::GetSingleton();
        $idsActividades = $userAppService->getActividadesUsuario($user->id());


        if (!empty($idsActividades)) {
          echo '<link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">';  
           
          $html = '<table class="tabla-actividades"><tr>'; 
          $colCount = 0;
          $actividadAppService = actividadAppService::GetSingleton();
           
            foreach ($idsActividades as $idActividad) {

              $actividad = $actividadAppService->getActividadById($idActividad);

              if ($colCount > 0 && $colCount % 3 == 0) {
                $html .= '</tr><tr>'; 
              }
              $colCount++;

              //hay que crear un metodo para muestrar ya que le pasamos la actividad entera

              $html .= '<td>' . $actividadAppService->mostrar($actividad) . '</td>';   

            }
            $html .= '</tr></table>';
           
        } else {
          $html .= '<p><em>No hay actividades disponibles para este usuario.</em></p>';
        }
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
