<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo1.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
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

		</div> 

	</body>
</html>
