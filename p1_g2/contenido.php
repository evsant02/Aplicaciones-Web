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
    // Redirigir a la página de actividades si la sesión está iniciada
    header("Location: actividades.php");
    exit();
}

require("includes/comun/plantilla.php");
?>