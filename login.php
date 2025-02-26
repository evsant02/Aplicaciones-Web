<?php

// Verificar si el usuario ya está logueado
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: contenido.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Login</title>
	<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
</head>
<body>
<div id="contenedor"> <!-- Inicio del contenedor -->
    <?php include 'includes\vistas\comun\cabecera.php'; ?>
    <?php include 'includes\vistas\comun\sidebarIzq.php'; ?>
    <?php include 'includes\vistas\comun\sidebarDer.php'; ?>

    <main>
        <h1>Acceso al sistema</h1>
        <form action="procesarLogin.php" method="post">
			<fieldset>
					<legend>Usuario y contraseña</legend>
					<p><label>Nombre:</label> <input type="text" name="username" /></p>
					<p><label>Contraseña:</label> <input type="password" name="password" /></p>
					<button type="submit">Enviar</button>
			</fieldset>
        </form>
    </main>

    <?php include 'includes\vistas\comun\pie.php'; ?>

</div> <!-- Fin del contenedor -->
</body>
</html>

