<?php
session_start();
include 'barraMenu.php'; // Incluye la barra de navegación
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conecta65</title>
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css"> <!-- Cargar estilos -->
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php">
                    <img src="Imagenes/logo.jpeg" alt="Logo Conecta65">
                </a>
            </div>
            <?php mostrarMenu(); ?> <!-- Muestra la barra de menú -->
        </nav>
    </header>
