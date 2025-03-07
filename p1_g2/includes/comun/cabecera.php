<?php
function mostrarSaludo() 
{
    if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) 
    {
        // Obtener el nombre del usuario
        $user = application::getInstance()->getUserDTO();
        echo "Bienvenido, " . $user->nombre() . ". <a href='logout.php'>(salir)</a>";
    } 
    else 
    {
        echo "Usuario desconocido. <a href='login.php'>Login.</a>";
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
