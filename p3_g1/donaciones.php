<?php
require_once("includes/config.php");
require_once("includes/donacion/donacionAppService.php");

use includes\donacion\donacionAppService;

$tituloPagina = 'Donaciones - Conecta65';

// Obtener estadísticas
$donacionService = donacionAppService::GetSingleton();
$estadisticas = $donacionService->getEstadisticasDonaciones();

// Construir el contenido principal correctamente
$contenidoPrincipal = <<<EOS
<div class="default">
    <h1>Impacto de tus donaciones</h1>

    <!-- Elemento oculto con los datos para JavaScript -->
    <script id="chart-data" type="application/json">
EOS;

// Añadir los datos JSON (sin sobrescribir $contenidoPrincipal)
$contenidoPrincipal .= json_encode($estadisticas['datosGrafico']);

// Continuar con el resto del HTML
$contenidoPrincipal .= <<<EOS
    </script>
    
    <div class="donaciones-container">
        <div class="donaciones-stats">
            <div class="stat-card total">
                <h3>Total recaudado</h3>
                <div class="stat-value">{$estadisticas['total']} €</div>
                <p>Desde el inicio de la iniciativa</p>
            </div>
            
            <div class="stat-card last-quarter">
                <h3>Últimos 3 meses</h3>
                <div class="stat-value">{$estadisticas['ultimoTrimestre']} €</div>
                <p>Tu apoyo reciente</p>
            </div>
            
            <div class="stat-card last-month">
                <h3>Último mes</h3>
                <div class="stat-value">{$estadisticas['ultimoMes']} €</div>
                <p>Impulso actual</p>
            </div>
        </div>
        
        <div class="donaciones-chart">
            <h3>Evolución de donaciones</h3>
            <canvas id="donacionesChart"></canvas>
        </div>
    </div>
    
    <div class="donaciones-info">
        <p>Cada donación nos ayuda a seguir con nuestro trabajo. ¡Gracias por tu apoyo!</p>
        <a href="donar.php" class="btn-donar">Hacer nueva donación</a>
    </div>
</div>
EOS;

// Los scripts deben ir en la plantilla, no aquí
$scripts = [
    'https://cdn.jsdelivr.net/npm/chart.js',
    'js/donacionesChart.js'
];

require("includes/comun/plantilla.php");