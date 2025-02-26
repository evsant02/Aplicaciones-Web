<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION['login']);
unset($_SESSION['nombre']);
unset($_SESSION['esAdmin']);
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Logout</title>
</head>
<body>
<div id="contenedor">
    <!-- Cabecera de la página web -->
	<?php include('includes\vistas\comun\cabecera.php'); ?>

	<!-- Menú de navegación -->
	<?php include('includes\vistas\comun\sidebarIzq.php'); ?>

    <main>
        <article>
            <h1>Sesión cerrada</h1>
            <p>Gracias por visitar nuestra web. Hasta pronto.</p>
        </article>
    </main>

    <!-- Navegación en la parte derecha -->
	<?php include('includes\vistas\comun\sidebarDer.php'); ?>

	<!-- Pie de página -->
	<?php include('includes\vistas\comun\pie.php'); ?>
</div>
</body>
</html>
