<?php
// Incluir la plantilla de la cabecera y menú
include 'header.php';
include 'Actividad.php';

// Crear una lista de actividades utilizando la clase Actividad ----> LUEGO SE CAMBIA POR BBDD
$actividades = [
    new Actividad(1, "Clase de Baile", "baile.jpg", "Disfruta bailando al ritmo de la música.", true, "Centro Cultural", "2025-03-10 18:00", "María López", 20),
    new Actividad(2, "Taller de Costura", "costura.jpg", "Aprende a coser tus propias prendas.", false, "Casa de la Cultura", "2025-03-12 16:00", null, 10),
    new Actividad(3, "Taller de Informática", "informatica.jpg", "Iníciate en el mundo de la informática.", true, "Biblioteca Municipal", "2025-03-15 10:00", "Pedro Sánchez", 8),
    new Actividad(4, "Huerto Urbano", "huerto.jpg", "Crea un huerto urbano en tu comunidad.", true, "Parque Central", "2025-03-18 09:00", "Lucía Gómez", 15),
    new Actividad(5, "Cocina Saludable", "cocina.jpg", "Recetas fáciles para una vida más saludable.", false, "Centro de Mayores", "2025-03-20 11:00", null, 5),
    new Actividad(6, "Manualidades", "manualidades.jpg", "Apúntate para exprimir al máximo tu creatividad.", true, "Asociación Vecinal", "2025-03-22 15:00", "Ana Rodríguez", 10),
    new Actividad(7, "Club de Lectura", "lectura.jpg", "Comparte con otras personas tus opiniones sobre la lectura propuesta cada mes.", true, "Librería El Rincón", "2025-03-25 17:30", "Carlos Pérez", 20),
    new Actividad(8, "Excursión al Palacio Real", "excursionPR.jpg", "Apúntate a visitar uno de los lugares más turísticos de Madrid.", true, "Palacio Real", "2025-03-28 08:00", "Sofía Fernández", 15),
];

// Determinar tipo de usuario (simulado) ---> se debera CAMBIAR
$tipo_usuario = isset($_GET['tipo']) ? $_GET['tipo'] : 'usuario'; //se puede cambiar a voluntario SE TIENE QUE COMPROBAR
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actividades</title>
    <link rel="stylesheet" type="text/css" href="CSS/tablaActividades.css">
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css"> 
    
   
</head>
<body>
    <h1>Actividades Disponibles</h1>
    <table>
        <tr>
            <?php 
            $colCount = 0;
            foreach ($actividades as $actividad): ?>
                <?php if (($tipo_usuario == 'usuario' && $actividad->getDirigida()) || 
                          ($tipo_usuario == 'voluntario' && !$actividad->getDirigida())): ?>
                    <?php 
                    if ($colCount > 0 && $colCount % 4 == 0) {
                        echo '</tr><tr>'; // Nueva fila después de 4 celdas
                    }
                    $colCount++;
                    ?>
                    <?php $actividad->mostrar($tipo_usuario); ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    </table>
</body>
</html>



<?php
include 'footer.php'; 
?>




