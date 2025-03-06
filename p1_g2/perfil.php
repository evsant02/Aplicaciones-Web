<?php 
  require_once("includes/config.php");

  $tituloPagina = 'Mi perfil - conecta65';

  $contenidoPrincipal = <<<EOS
  <h1>Login de usuario</h1>
  $htmlFormLogin
  EOS;

  require("includes/comun/plantilla.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi perfil - conecta65</title>
</head>
<body>
  <div id="contenedor">
    <?php 
      require('barraMenu.php');
    ?>
    <main>
      <h2>Bienvenid@, </h2>
      <?php
        if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
          echo "<p> <em>". $_SESSION['nombre'] . "</em> " . $_SESSION['apellidos'] . "</p>";          
          echo "<p> ". $_SESSION['correo'] . " | " . $_SESSION['fecha_nacimiento'] . "</p>";
          echo "<p> <em> Tipo de usuario <em> </p>";
        } 
      ?>
      <hr/>
      <?php
        if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] === true) { 
            echo '<button>Crear actividad</button>';            
        } 
        else {           
            echo '<p><em>Aquí se deberían mostrar las actividades reservadas por el usuario.</em></p>';            
        }
      ?>
    </main>
    <?php 
      require('pie.php');
    ?>
  </div>
</body>
</html>