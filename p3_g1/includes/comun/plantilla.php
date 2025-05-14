<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<link rel="stylesheet" media="screen and (max-width: 699px)" type="text/css" href="CSS/estiloMovil.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Título de la página, se utiliza una variable PHP para definir el título dinámicamente -->
		<title><?= $tituloPagina ?></title>
	</head>

	<?php
		require("cabecera.php");
	?>

	<?php if (!empty($scripts)): ?>
		<?php foreach ($scripts as $script): ?>
			<script src="<?= $script ?>"></script>
		<?php endforeach; ?>
	<?php endif; ?>

	<body>
		<!-- Contenedor principal de la página -->
		<div id="contenedor">

			<!-- Sección principal de contenido de la página -->
			<main>
				<article>
					<!-- Aquí se incluye dinámicamente el contenido principal de la página -->
					<?= $contenidoPrincipal ?>
				</article>
			</main>

			<?php
				require("pie.php");  // Se incluye el pie de página
			?>


		</div> <!-- Fin del contenedor -->
		<script src="js/lateral.js"></script>
	</body>
</html>
