<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <h1>Mi gran página web</h1>
	<div class="saludo">
		<?php
			if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
				echo "<p>Bienvenido, " . $_SESSION['nombre'] . " | <a href='logout.php'>(salir)</a></p>";
			} else {
				echo "<p>Usuario desconocido. <a href='login.php'>Login</a></p>";
			}
		?>
	</div>
</header>