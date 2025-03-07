<?php
function mostrarSaludo() {
    echo '<nav>';
    echo '<ul class="main-links">'; // Enlaces generales (izquierda)
    
    if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
        $user = application::getInstance()->getUserDTO();
        echo '<li><a href="vistaActividades.php">Actividades</a></li>'; // Solo si está logueado
    }
    
    echo '<li><a href="donaciones.php">Dona</a></li>';
    echo '<li><a href="ayuda.php">Ayuda</a></li>';
    echo '<li><a href="sobre_nosotros.php">Qué es Conecta65</a></li>';
    echo '</ul>';

    // Enlaces de usuario (derecha)
    echo '<div class="user-links"><ul>';
    
    if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
        echo "<li>Bienvenido, " . $user->nombre() . " <a href='perfil.php'>Perfil</a></li>";
        echo "<li><a href='logout.php'>(Salir)</a></li>";
    } else {
        echo "<li><a href='login.php'>Inicio Sesión</a></li>";
        echo "<li><a href='register.php'>Regístrate</a></li>";
    }

    echo '</ul></div>';
    echo '</nav>';
}
?>

<header>
    <div class="logo">
        <img src="img/logo.jpeg" alt="Logo">
    </div>
    <h1>Conecta65</h1>
    <div class="saludo">
        <?php mostrarSaludo(); ?>
    </div>
</header>
