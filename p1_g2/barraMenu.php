<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conecta65</title>
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="inicio.php"><img src="img/logo.jpeg" alt="Logo conecta65"> </a>
            </div>
            <ul>
                <li><a href="vistaActividades.php">Actividades</a></li>
                <li><a href="donar.php">Dona</a></li>
                <li><a href="ayuda.php">Ayuda</a></li>
                <li><a href="aboutus.php">Qué es <em>conecta65</em></a></li>
                <?php
                    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) 
                    {
                        echo "<li>Bienvenido, " . $_SESSION['nombre'] . ". <a href='inicio.php'>(salir)</a></li>";
                    } 
                    else 
                    {
                        echo '<li><a href="registro.php">Regístrate</a></li>
                                <li><a href="login.php">Iniciar Sesión</a></li>';
                    }
                ?>                
            </ul>
        </nav>
    </header>
</body>

