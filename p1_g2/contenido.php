<?php
// Incluye el archivo de configuración (manejo de sesiones, BD, etc.)
require_once("includes/config.php");

// Define el título de la página
$tituloPagina = 'Contenido';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["login"])) {
    // Si el usuario no ha iniciado sesión, muestra un mensaje de acceso restringido con un botón para iniciar sesión
    $contenidoPrincipal = <<<EOS
     <div class="contenido-centrado">
        <h1>Acceso restringido</h1>
        <p>Para visualizar más contenido, debes iniciar sesión.</p>
        <a href="login.php" class="boton boton-login">
            Iniciar Sesión
        </a>
    </div>
EOS;
} else {
    // Si el usuario ha iniciado sesión, verificar su rol
    if (application::getInstance()->soyAdmin()) { 
        // Si el usuario es administrador, obtiene sus datos
        $user = application::getInstance()->getUserDTO();

        // Muestra un mensaje personalizado con opciones para gestionar actividades
        $contenidoPrincipal = <<<EOS
        <div class="contenido-centrado">
            <h1>Bienvenido, {$user->nombre()}</h1>
            <p>Eres un administrador. Puedes gestionar actividades.</p>
            <a href="crearActividad.php" class="boton boton-crear">
                Crear Actividad
            </a>
            <a href="EditarActividades.php" class="boton boton-modificar">
                Modificar Actividad
            </a>
        </div>
EOS;
    } else {
        // Redirigir a la página de actividades para otros roles
        header("Location: vistaActividades.php");
        exit();
    }
}

// Incluye la plantilla para mostrar el contenido generado
require("includes/comun/plantilla.php");
?>