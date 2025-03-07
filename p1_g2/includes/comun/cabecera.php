<?php
function mostrarSaludo() {
    echo '<ul>';
    echo '<li><a href="vistaActividades.php">Actividades</a></li>';
    echo '<li><a href="donaciones.php">Dona</a></li>';
    echo '<li><a href="ayuda.php">Ayuda</a></li>';
    echo '<li><a href="sobre_nosotros.php">Qué es Conecta65</a></li>';

    if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
        echo "<li>Bienvenido, " . $_SESSION['nombre'] . " <a href='perfil.php'>Perfil</a></li>";
        echo "<li><a href='logout.php'>(Salir)</a></li>";
    } else {
        echo "<li><a href='login.php'>Inicio Sesión</a></li>";
        echo "<li><a href='registro.php'>Regístrate</a></li>";
    }
    echo '</ul>';
}
?>

<header>
    <div class="logo">
        <img src="img/logo.jpeg" alt="Logo">
    </div>
    <h1>Conecta65</h1>
    <nav>
        <div class="saludo">
            <?php mostrarSaludo(); ?>
        </div>
    </nav>
</header>
