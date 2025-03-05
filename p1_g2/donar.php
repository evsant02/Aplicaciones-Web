<?php 
  session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Haz una donación - conecta65</title>
</head>
<body>
  <div id="contenedor">
    <?php 
      require('barraMenu.php');
    ?>
    <main>
      <h1>Haz una donación para apoyar nuestra iniciativa!</h1>
      <form action="donar.php">
        <fieldset>
          <p><label>Cantidad:</label> <input type="number" name="cantidad"/> €</p> 
          <p><label>IBAN:</label> <input type="text" name="iban" /></p>
          <p><label>Nombre:</label> <input type="text" name="name" /></p>
          <p><label>Apellidos:</label> <input type="text" name="surname" /></p>
          <p>
            <input type="checkbox" id="anonimo" name="anonimo" value="anonimo">
            <label id="checkbox">Realizar la donación de manera anónima</label>
          </p>
          <button type="submit">Donar</button>
        </fieldset>
      </form>
    </main>
    <?php 
      require('pie.php');
    ?>
  </div>
</body>
</html>