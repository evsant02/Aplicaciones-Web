<?php
namespace includes\comun;

require_once(__DIR__ . "/../config.php");

use includes\application;

// Verificar si la función ya existe antes de declararla
if (!function_exists('includes\comun\mostrarCabecera')) {
    function mostrarCabecera() {
        $app = application::getInstance();
    
        echo '<nav>';
        echo '<ul class="main-links">'; // Enlaces generales (izquierda)
        
        if ($app->isUserLogged()) {
            $user = $app->getUserDTO();
            echo '<li><a href="vistaActividades.php">Actividades</a></li>'; // Solo si está logueado
            echo '<li><a href="vistaActividadesFiltradas.php">Búsqueda de Actividades</a></li>';
            echo '<li><a href="vistaForoNoticias.php">Foro de Noticias</a></li>'; // Solo si está logueado se muestra el foro de noticias
        }
        
        // Menú desplegable para Dona
        echo '<li class="dropdown">';
        echo '<a href="javascript:void(0)" class="dropbtn">Donaciones</a>';
        echo '<div class="dropdown-content">';
        echo '<a href="donar.php">Quiero Donar</a>';
        echo '<a href="donaciones.php">Recaudación</a>';
        echo '</div>';
        echo '</li>';
        
        echo '<li><a href="ayuda.php">Ayuda</a></li>';

        // Menú desplegable para Qué es Conecta65
        echo '<li class="dropdown">';
        echo '<a href="javascript:void(0)" class="dropbtn">Qué es Conecta65</a>';
        echo '<div class="dropdown-content">';
        echo '<a href="aboutus.php">Sobre Conecta65</a>';
        echo '<a href="miembros.php">Nuestro Equipo</a>';
        echo '</div>';
        echo '</li>';
        echo '</ul>';
    
        // Enlaces de usuario (derecha)
        echo '<div class="user-links"><ul>';
        
        if ($app->isUserLogged()) {
            echo "<li><a href='perfil.php'>Perfil " .$user->nombre(). "</a></li>";
            echo "<li><a href='logout.php'>(Salir)</a></li>";
        } else {
            echo "<li><a href='login.php'>Iniciar Sesión</a></li>";
            echo "<li><a href='register.php'>Regístrate</a></li>";
        }
    
        echo '</ul></div>';
        echo '</nav>';
    }
}
?>

<header>
    <div class="logo">
        <a href="index.php">
            <img src="img/logo.jpeg" alt="Logo">
        </a>
    </div>
    <h1>Conecta65</h1>
    <div class="cabecera">
        <?php mostrarCabecera(); ?>
    </div>
</header>
<body>
    <script src="js/dropdown.js"></script>
</body>