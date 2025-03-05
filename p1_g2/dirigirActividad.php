<?php
include 'header.php';
include 'Actividad.php';

// Simulación de actividades---> ESTO SALE DE LA BBDD (CAMBIAR)
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

// Obtener la actividad seleccionada
$id = isset($_GET['id']) ? $_GET['id'] : null;
$actividad = null;
foreach ($actividades as $act) {
    if ($act->getId() == $id) {
        $actividad = $act;
        break;
    }
}


// Verificar si el usuario está autenticado -> solo se muestran los detalles si el usuario está registrado
/*if (!isset($_SESSION['usuario'])) {
    echo "<p>Por favor, inicia sesión para realizar una reserva.</p>";
    exit; // Evitar que la vista de la actividad se muestre si no hay sesión.
}*/




// Simular la acción de que un voluntario se ofrezca a dirigir HAY QUE COMPROBAR QUE EL USUARIO NO HAYA RESERVADO YA ANTERIORMENTE ESTA ACTIVIDAD
if (isset($_POST['ofrecer'])) {
    if ($actividad && !$actividad->getVoluntario()) {
        $actividad->setVoluntario("Juan Pérez"); // Asignamos al voluntario a la actividad   ---> METER EN ACTIVIDAD
        echo "<p>¡Te has ofrecido a dirigir la actividad con éxito!</p>";
    } else {
        echo "<p>Esta actividad ya tiene un voluntario asignado.</p>";
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dirigir Actividad</title>
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
    <link rel="stylesheet" type="text/css" href="CSS/estiloActividad.css">
</head>
<body>
    <?php if ($actividad): ?>
        <div class="actividad">
            <div class="actividad-img">
                <img src="Imagenes/<?php echo $actividad->getImagen(); ?>" alt="Imagen de la actividad">
            </div>

            <div class="actividad-detalles">
                <h1><?php echo $actividad->getTitulo(); ?></h1>
                <p><strong>Descripción:</strong> <?php echo $actividad->getDescripcion(); ?></p>
                <p><strong>Ubicación:</strong> <?php echo $actividad->getUbicacion(); ?></p>
                <p><strong>Fecha y hora:</strong> <?php echo $actividad->getFecha(); ?></p>
                <p><strong>Dirigido por:</strong> <?php echo $actividad->getVoluntario() ? $actividad->getVoluntario() : "Ningún voluntario asignado"; ?></p>
                <p><strong>Plazas disponibles:</strong> <?php echo $actividad->getPlazas(); ?></p>

                <!-- Formulario para que el voluntario se ofrezca a dirigir la actividad -->
                <?php if ($actividad->getVoluntario() === null): ?>
                    <form method="post">
                        <button type="submit" name="ofrecer">Ofrecerme para dirigir la actividad</button>
                    </form>
                <?php else: ?>
                    <p>Un voluntario ya se ha ofrecido para dirigir esta actividad.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <p>Actividad no disponible.</p>
    <?php endif; ?>
</body>
</html>

<?php
include 'footer.php'; 
?>