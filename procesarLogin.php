<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$usuarios = [
    "user" => "userpass",
    "admin" => "adminpass"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (isset($usuarios[$username]) && $usuarios[$username] === $password) {
        $_SESSION['login'] = true;
		
		if ($username === "admin") {
            $_SESSION['nombre'] = "Administrador";
        }
		else {
			$_SESSION['nombre'] = "Usuario";
		}
        
        if ($username === "admin") {
            $_SESSION['esAdmin'] = true;
        }
    }
}

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
            <?php 
				if (isset($usuarios[$username]) && $usuarios[$username] === $password) {
					echo "<p>Bienvenido, " . $_SESSION['nombre'] . ". Usa el menú de la izquierda para navegar.</p>"; 
				} else {
					echo "<p>Error: Usuario o contraseña incorrectos. <a href='login.php'>Intentar de nuevo</a></p>";
				}		
			?>
        </article>
    </main>

    <!-- Navegación en la parte derecha -->
	<?php include('includes\vistas\comun\sidebarDer.php'); ?>

	<!-- Pie de página -->
	<?php include('includes\vistas\comun\pie.php'); ?>
</div>
</body>
</html>
