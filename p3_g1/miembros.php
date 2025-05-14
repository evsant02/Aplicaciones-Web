<?php
require_once("includes/config.php");

$tituloPagina = 'Miembros - conecta65';

//Array de los miembros del equipo
$miembros = [
    [
    
        'nombre' => 'Umaima',
        'apellidos' => 'Chaoui Benmousa',
        'email' => 'uchaoui@ucm.es',
        'Intereses' => 'Intereses: El fútbol, las motos de agua, viajar y pasar tiempo con sus amigos.',
        'foto' => 'img/umaima.jpg'
    ],
    [
        
        'nombre' => 'Eva',
        'apellidos' => 'Santos Sánchez',
        'email' => 'evsant02@ucm.es',
        'Intereses' => 'Intereses: Los deportes de riesgo, los videojuegos y viajar alrededor del mundo.',
        'foto' => 'img/eva.jpg'
    ],
    [
      
        'nombre' => 'Martina',
        'apellidos' => 'Águeda Garcia',
        'email' => 'martia01@ucm.es',
        'Intereses' => 'Intereses: La música, pasar tiempo con su circulo, leer y hacer deporte',
        'foto' => 'img/martina.jpg'
    ],
    [
       
        'nombre' => 'Débora',
        'apellidos' => 'Rubio Galindo',
        'email' => 'derubio@ucm.es',
        'Intereses' => 'Intereses: Viajar por todos los continentes, ver películas y series.',
        'foto' => 'img/debora.jpg'
    ],
    [
        
        'nombre' => 'Javier',
        'apellidos' => 'García Sánchez',
        'email' => 'javiga29@ucm.es',
        'Intereses' => 'Intereses: La lectura, videojuegos como Pokemon, Overcooked y Animal Crossing.',
        'foto' => 'img/javier.jpg'
    ]
    
];

$contenidoPrincipal = <<<EOS
    <div class="aboutus">
        <div class="team-header">
            <h1>Nuestro equipo</h1>
            <p>Conoce a las personas detrás de conecta65</p>
        </div>

        <div class="team-members-container">
            <div class="team-members-grid">
EOS;

$colCount = 0;
foreach ($miembros as $miembro) {
    if ($colCount > 0 && $colCount % 3 == 0) {
        $contenidoPrincipal .= '</tr><tr>'; 
    }
    $colCount++;
    
    $contenidoPrincipal .= <<<EOS
            <div class="member-card">
                <div class="member-basic-info">
                    <img src="{$miembro['foto']}" alt="{$miembro['nombre']} {$miembro['apellidos']}" class="member-photo">
                    <h3>{$miembro['nombre']} {$miembro['apellidos']}</h3>
                </div>
                <div class="member-details">
                    <p class="member-description">{$miembro['email']}</p>
                    <p class="member-description">{$miembro['Intereses']}</p>
                </div>
            </div>
EOS;
}

$contenidoPrincipal .= <<<EOS
            </div>
        </div>
    </div>
EOS;

require("includes/comun/plantilla.php");
?>