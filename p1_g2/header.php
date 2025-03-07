<?php
session_start();
include 'barraMenu.php'; // Incluye la barra de navegación CREO QUE ESTO NO SE ESTÁ USANDO TAMPOCO
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conecta65</title>
    <link rel="stylesheet" type="text/css" href="CSS/estilo1.css"> <!-- Cargar estilos -->
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php">
                    <img src="img/logo.jpeg" alt="Logo Conecta65">
                </a>
            </div>
            <?php mostrarMenu(); ?> <!-- Muestra la barra de menú -->
        </nav>
    </header>
