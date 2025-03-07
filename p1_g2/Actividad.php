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

 

    // Método para obtener el enlace según el tipo de usuario
    public function getEnlace($tipo_usuario) {
        if ($tipo_usuario == 'usuario') {
            return "vistaReservaActividad.php?id=" . $this->id;
        } else {
            return "vistaDirigirActividad.php?id=" . $this->id;
        }
    }


    //muestra las actividades HTML
    public function mostrar($tipo_usuario) {
        $html = '<div class="actividad">';
        $html .= '<img src="img/' . $this->imagen . '" alt="' . $this->titulo . '">';
        $html .= '<h3>' . $this->titulo . '</h3>';
        $html .= '<p class="descripcion">' . $this->descripcion . '</p>';
        $html .= '<a href="' . $this->getEnlace($tipo_usuario) . '" class="btn">' . ($tipo_usuario == 'usuario' ? 'Inscribirse' : 'Dirigir') . '</a>';
        $html .= '</div>';
        return $html;  //se devuelve en html
    }
    


    // Getters 
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getImagen() { return $this->imagen; }
    public function getDescripcion() { return $this->descripcion; }
    public function getDirigida() { return $this->dirigida; }
    public function getUbicacion() { return $this->ubicacion; }
    public function getFecha() { return $this->fecha; }
    public function getVoluntario() { return $this->voluntario; }
    public function getPlazas() { return $this->plazas; }


    //Setters
    public function setPlazas($plazas) { $this->plazas = $plazas; } //resta al numero de plazas
    public function setVoluntario($voluntario){$this->voluntario = $voluntario;}
    public function setDirigida($dirigida){$this->dirigida = $dirigida;}





}
?>
