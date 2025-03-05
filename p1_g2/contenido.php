<?php
require_once("includes/config.php");

$tituloPagina = 'Contenido';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["login"])) {
    $contenidoPrincipal = <<<EOS
    <div style="text-align: center; padding: 20px;">
        <h1>Acceso restringido</h1>
        <p>Para visualizar más contenido, debes iniciar sesión.</p>
        <a href="login.php" style="display: inline-block; padding: 10px 20px; margin-top: 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
            Iniciar Sesión
        </a>
    </div>
EOS;
} else {
    // Verificar el rol del usuario

    //application::getInstance()->soyAdmin()
    if ($_SESSION["tipo"] == 0) {
        // Contenido para el rol 0 (crear y modificar actividades)
        $contenidoPrincipal = <<<EOS
        <div style="text-align: center; padding: 20px;">
            <h1>Bienvenido, {$_SESSION['nombre']}</h1>
            <p>Eres un administrador. Puedes gestionar actividades.</p>
            <a href="crearActividad.php" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;">
                Crear Actividad
            </a>
            <a href="EditarActividades.php" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #ffc107; color: black; text-decoration: none; border-radius: 5px;">
                Modificar Actividad
            </a>
        </div>
EOS;
    } else {
        // Redirigir a la página de actividades para otros roles
        header("Location: index.php");
        exit();
    }
}

require("includes/comun/plantilla.php");
?>