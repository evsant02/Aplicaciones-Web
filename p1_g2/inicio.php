<?php 
  session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio - conecta65</title>
</head>
<body>
  <div id="contenedor">
    <?php 
      require('barraMenu.php');
    ?>
    <main>
      <?php
        echo '<img src="img/inicio.jpg" alt="Personas mayores andando" width="800">';
        echo '<div class="botonesIni">';
        echo '<button>Ver actividades</button>';
        echo '<button>Hacer una donación</button>';
        echo '</div>';
      ?>
    </main>
    <?php 
      require('pie.php');
    ?>
  </div>
</body>
</html>