<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" media="screen and (max-width: 699px)" type="text/css" href="CSS/estiloMovil.css" />
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Título de la página, se utiliza una variable PHP para definir el título dinámicamente -->
		<title><?= $tituloPagina ?></title>
	</head>

	<?php
		require("includes/comun/cabecera.php");
		//require("includes/comun/sidebarIzq.php");  // Comentado, se podría incluir una barra lateral izquierda
	?>

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
				//require("includes/comun/sidebarDer.php");  // Comentado, se podría incluir una barra lateral derecha
				require("includes/comun/pie.php");  // Se incluye el pie de página
			?>


		</div> <!-- Fin del contenedor -->

	</body>
</html>
