<?php
// Función que muestra un saludo personalizado o un mensaje de login según el estado de sesión.
function mostrarSaludo() 
{
    // Verifica si la sesión está iniciada y el valor de 'login' es verdadero.
    if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) 
    {
        // Si está logueado, obtiene el objeto del usuario.
        $user = application::getInstance()->getUserDTO();
        
        // Muestra un mensaje de bienvenida con el nombre del usuario y un enlace para salir.
        echo "Bienvenido, " . $user->nombre() . ". <a href='logout.php'>(salir)</a>";
    } 
    else 
    {
        // Si no está logueado, muestra un mensaje indicando que el usuario es desconocido y un enlace para hacer login.
        echo "Usuario desconocido. <a href='login.php'>Login.</a>";
    }
}
?>

<header>
    <!-- Título de la página flotante hacia la izquierda -->
    <h1 style="float: left;">Conecta65</h1> 
    
    <div class="saludo">
        <!-- Llama a la función mostrarSaludo() para mostrar el mensaje adecuado -->
        <?php
            mostrarSaludo(); 
        ?>
    </div>
</header>