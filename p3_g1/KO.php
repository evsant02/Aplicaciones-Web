<?php
require_once("includes/config.php");

$tituloPagina = 'Error en la donación - conecta65';

$contenidoPrincipal = <<<EOS
<div class="default">
    <h1>Error en el proceso de donación</h1>
    
    <div>
        <p>No hemos podido completar tu donación.</p>
                
        <p>Por favor, inténtelo de nuevo o póngase en contacto con su entidad bancaria si el problema persiste.</p>
    
        <a href="donar.php"><button>Intentar de nuevo</button></a>
        <a href="ayuda.php"><button>Ayuda</button></a>
        <a href="index.php"><button>Volver al inicio</button></a>
    </div>
</div>
EOS;

require("includes/comun/plantilla.php");