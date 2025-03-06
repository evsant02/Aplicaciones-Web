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
}
?>

<header>
    <h1 style="float: left;">Conecta65</h1> 
    <div class="saludo">
        <?php
            mostrarSaludo(); 
        ?>
    </div>
</header>