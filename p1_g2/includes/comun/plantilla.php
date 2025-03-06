<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?= $tituloPagina ?></title>
	</head>

			<?php
				require("includes/comun/cabecera.php");
				//require("includes/comun/sidebarIzq.php");
			?>
	<body>
		
		<div id="contenedor">



			<main>
				<article>
					<?= $contenidoPrincipal ?>
				</article>
			</main>

			<?php
				//require("includes/comun/sidebarDer.php");
				require("includes/comun/pie.php");
			?>

		</div> 

	</body>
</html>