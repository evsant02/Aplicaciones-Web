<?php
  require_once("includes/config.php");

  $tituloPagina = 'Sobre nosotros - conecta65';
  // se muestra información sobre la aplicación
  $contenidoPrincipal = <<<EOS
      <div class="aboutus">
        <h1>¿Qué es conecta65?</h1>
        <h3>Bienvenid@ a nuestra aplicación</h3>
        <p>
          Somos una plataforma web diseñada para fomentar el envejecimiento activo y combatir la soledad en personas mayores mediante su integración activa 
          en actividades creativas y colaborativas.
        </p>
        <p>
          La aplicación facilita la organización y gestión de talleres de jardinería, carpintería, costura, baile y cocina, entre otras actividades, permitiendo que 
          los participantes mantengan sus capacidades sociales y físicas activas. 
        </p>
        <p>
          Además, la plataforma cuenta con una sección de donaciones, donde personas externas pueden contribuir económicamente. Los fondos recaudados 
          a través de esta área se destinan tanto a proyectos comunitarios como a residencias de mayores, con el objetivo de mejorar sus instalaciones y 
          servicios, beneficiando directamente la calidad de vida de sus residentes.
        </p>
        <p>
          Asimismo, la plataforma busca fomentar la conexión entre generaciones mediante la inclusión de voluntarios de diferentes edades en las actividades, 
          fortaleciendo vínculos comunitarios. A través de esta propuesta, no solo se pretende que las personas mayores redescubran su propósito y creatividad, 
          sino también contribuir activamente a su entorno, promoviendo una sociedad más inclusiva y solidaria.
        </p>
        <img src="img/ajedrez.jpg" alt="Personas mayores andando" width="800">
      </div>
  EOS;

  require("includes/comun/plantilla.php");
?>