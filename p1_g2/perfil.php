<?php

  function mostrarPerfil(): string {
    $user = application::getInstance()->getUserDTO();
    $html = null;

    if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) {
        $html .= "<h2><p> <em>Bienvenid@, " . $user->nombre() . "</em> " . $user->apellidos() . "</p></h2>";
        $html .= "<p> " . $user->correo() . " | " . $user->fecha_nacimiento() . "</p>";
        //$html .= "<p> <em> Tipo de usuario </em> </p>";
    }
    $html .= '<hr/>';
    if (application::getInstance()->soyAdmin()) {
        $html .= "<p> <em> Administrador </em> </p>"; //
        $html .= '<a href="CrearActividad.php"><button>Crear actividad</button></a>';
        $html .= '<a href="EditarActividades.php"><button>Modificar actividad</button></a>';
      } else {
        $html .= "<p> <em> Usuario/Voluntario </em> </p>"; //
        $html .= '<p><em>Aquí se mostrarán las actividades reservadas por el usuario/voluntario en la próxima práctica.</em></p>';
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