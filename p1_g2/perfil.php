<?php
  function mostrarPerfil(): string {
    $html = '<h2>Bienvenid@, </h2>';
    if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) {
        $html .= "<p> <em>" . $_SESSION['nombre'] . "</em> " . $_SESSION['apellidos'] . "</p>";
        $html .= "<p> " . $_SESSION['correo'] . " | " . $_SESSION['fecha_nacimiento'] . "</p>";
        $html .= "<p> <em> Tipo de usuario </em> </p>";
    }
    $html .= '<hr/>';
    if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] === true) {
        $html .= '<button>Crear actividad</button>';
    } else {
        $html .= '<p><em>Aquí se deberían mostrar las actividades reservadas por el usuario.</em></p>';
    }
    return $html;
  }

?>

<?php 
  require_once("includes/config.php");

  $tituloPagina = 'Mi perfil - conecta65';

  $contenidoPrincipal = mostrarPerfil();

  require("includes/comun/plantilla.php");
?>