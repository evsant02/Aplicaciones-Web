<?php 
  session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ayuda - conecta65</title>
</head>
<body>
  <div id="contenedor">
    <?php 
      require('barraMenu.php');
    ?>
    <main>
      <h3>¿Necesitas ayuda?</h3>
      <p>Ponte en contacto con nuestro equipo para que podamos ayudarte.</p>
      <form action="procesarLogin.php" method="POST">
        <fieldset>
        <p><label>e-mail:</label> <input type="text" name="email"/></p> 
        <p><label>Detalles:</label> <input type="text" name="detalles"/></p>
        <button type="submit">Enviar</button>
        </fieldset>
      </form>
    </main>
    <?php 
      require('pie.php');
    ?>
  </div>
</body>
</html>