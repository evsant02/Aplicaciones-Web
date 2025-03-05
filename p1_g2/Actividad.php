<?php
class Actividad {
    // Propiedades
    private $id;
    private $titulo;
    private $imagen;
    private $descripcion;
    private $dirigida; //true o false
    private $ubicacion;
    private $fecha;
    private $voluntario; //si la actividad no está dirigida, esto será null
    private $plazas;

    // Constructor actualizado con nuevas propiedades
    public function __construct($id, $titulo, $imagen, $descripcion, $dirigida, $ubicacion, $fecha, $voluntario, $plazas) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->imagen = $imagen;
        $this->descripcion = $descripcion;
        $this->dirigida = $dirigida;
        $this->ubicacion = $ubicacion;
        $this->fecha = $fecha;
        $this->voluntario = $voluntario;
        $this->plazas = $plazas;
    }

    // Método para obtener el enlace de reserva
   /* public function getEnlace() {
        return "reservaActividad.php?id=" . $this->id;
    }*/

    // Método para obtener el enlace según el tipo de usuario
    public function getEnlace($tipo_usuario) {
        if ($tipo_usuario == 'usuario') {
            return "reservaActividad.php?id=" . $this->id;
        } else {
            return "dirigirActividad.php?id=" . $this->id;
        }
    }

// Método para mostrar la actividad en formato HTML segun tipo de usuario
/*public function mostrar($tipo_usuario) {
    echo '<td>';
    echo '<div class="actividad">';
    echo '<img src="Imagenes/' . $this->imagen . '" alt="' . $this->titulo . '">';
    echo '<h3>' . $this->titulo . '</h3>';
    echo '<p class="descripcion">' . $this->descripcion . '</p>';
    echo '<a href="' . $this->getEnlace($tipo_usuario) . '" class="btn">' . ($tipo_usuario == 'usuario' ? 'Inscribirse' : 'Dirigir') . '</a>';
    echo '</div>';
    echo '</td>';
}*/



    // Método para mostrar la actividad en formato HTML
    public function mostrar($tipo_usuario) {
        echo '<td>';
        echo '<div class="actividad">';
        echo '<img src="Imagenes/' . $this->imagen . '" alt="' . $this->titulo . '">';
        echo '<h3>' . $this->titulo . '</h3>';
        echo '<p class="descripcion">' . $this->descripcion . '</p>';
        //echo '<a href="' . $this->getEnlace() . '" class="btn">Ver detalles</a>'; //CAMBIAR
        echo '<a href="' . $this->getEnlace($tipo_usuario) . '" class="btn">' . ($tipo_usuario == 'usuario' ? 'Inscribirse' : 'Dirigir') . '</a>';
        echo '</div>';
        echo '</td>';
    }

    // Getters para las nuevas propiedades
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getImagen() { return $this->imagen; }
    public function getDescripcion() { return $this->descripcion; }
    public function getDirigida() { return $this->dirigida; }
    public function getUbicacion() { return $this->ubicacion; }
    public function getFecha() { return $this->fecha; }
    public function getVoluntario() { return $this->voluntario; }
    public function getPlazas() { return $this->plazas; }
}
?>
