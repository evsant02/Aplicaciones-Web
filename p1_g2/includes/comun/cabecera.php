<?php
function mostrarSaludo() 
{
    if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) 
    {
        echo "Bienvenido, " . $_SESSION['nombre'] . ". <a href='logout.php'>(salir)</a>";
        /*echo " <a href='dona.php'>Actividades</a>";
        echo " <a href='dona.php'>Dona</a>";
        echo " <a href='nosotros.php'>Qué es Conecta65</a>";
        echo " <a href='dona.php'>Ayuda</a>";*/
    } 
    else 
    {
        /*echo "Usuario desconocido. <a href='login.php'>Login</a>";
        echo " <a href='dona.php'>Dona</a>";
        echo " <a href='nosotros.php'>Qué es Conecta65</a>";*/
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