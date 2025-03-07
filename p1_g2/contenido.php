<?php
require_once("includes/config.php");

$tituloPagina = 'Contenido';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["login"])) {
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
    // Verificar el rol del usuario
    $user = application::getInstance()->getUserDTO();

    if (application::getInstance()->soyAdmin()) {
        // Contenido para el rol 0 (crear y modificar actividades)
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
        header("Location: index.php");
        exit();
    }
}

require("includes/comun/plantilla.php");
?>