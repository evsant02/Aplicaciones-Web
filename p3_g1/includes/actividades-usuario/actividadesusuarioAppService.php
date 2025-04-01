
<?php

// Se requiere el archivo que contiene la fábrica de actividades
require_once("actividadesusuarioFactory.php");

// Clase que gestiona el servicio de aplicación para las actividades
class actividadesusuarioAppService
{
    // Propiedad estática para almacenar la única instancia del servicio (Singleton)
    private static $instance;

    // Método que devuelve la única instancia de la clase (patrón Singleton)
    public static function GetSingleton()
    {
        // Si no existe una instancia, se crea una nueva
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

    // Constructor privado para evitar la creación de múltiples instancias
    private function __construct()
    {
    } 

    // Método para crear una nueva actividad en la base de datos
    public function crear($actividadesusuarioDTO)
    {
        // Se obtiene una instancia del DAO a través de la fábrica
        $IActividadesusuarioDAO = actividadesusuarioFactory::CreateActividad();
        // Se llama al método correspondiente para crear la actividad
        $foundedactividadesusuarioDTO = $IActividadesusuarioDAO->crear($actividadesusuarioDTO);
        return $foundedactividadesusuarioDTO;
    }

    // Método para eliminar una actividad existente por ID
    public function eliminarPorId($id)
    {
        // Se obtiene una instancia del DAO
        $IActividadDAO = actividadFactory::CreateActividad();
        
        // Buscar la actividad por ID
        $actividad = $IActividadDAO->getActividadById($id);
        
        // Si la actividad no existe, retornar falso
        if ($actividad === null) {
            return false;
        }

        // Llamar al método de eliminación del DAO
        $eliminada = $IActividadDAO->eliminar($actividad);

        // Retornar el resultado de la eliminación (true si fue exitosa, false si no)
        return $eliminada;
    }

    // Método para modificar una actividad existente
    public function modificar($actividadDTO)
    {
        // Se obtiene una instancia del DAO
        $IActividadDAO = actividadFactory::CreateActividad();
        // Se llama al método de modificación
        $modificadaactividadDTO = $IActividadDAO->modificar($actividadDTO);
        return $modificadaactividadDTO;
    }

    // Método para obtener todas las actividades almacenadas en la base de datos
    public function obtenerTodasLasActividades()
    {
        // Se obtiene una instancia del DAO
        $IActividadDAO = actividadFactory::CreateActividad();
        // Se llama al método de consulta
        $actividades = $IActividadDAO->obtenerTodasLasActividades();
        return $actividades;
    }

    //Método par obtener las actividades segun el tipo de usuario
    public function obtenerActividadSegunUsuario(): array
    {
        //si es admin, se muestran todas las actividades
        if (application::getInstance()->soyAdmin()){            
            $actividades= $this->obtenerTodasLasActividades();
            return $actividades;
        }

        //si es voluntario, se muestran solo aquellas que no están dirigidas
        else if (application::getInstance()->soyVoluntario()){            
            // Se obtiene una instancia del DAO
            $IActividadDAO = actividadFactory::CreateActividad();
            // Se llama al método de consulta
            $actividades = $IActividadDAO->obtenerActSinDirigir();           
            return $actividades;
        }

        //si es usuario, solo se muestran las que ya tienen un voluntario asignado y no tienen el aforo al maximo
        else {
            // Se obtiene una instancia del DAO
            $IActividadDAO = actividadFactory::CreateActividad();
            // Se llama al método de consulta
            $actividades = $IActividadDAO->obtenerActSinCompletar();
            return $actividades;
        }

    }

    
    // Método para obtener una actividad específica por su ID
    public function getActividadById($id)
    {
        // Se obtiene una instancia del DAO
        $IActividadDAO = actividadFactory::CreateActividad();
        // Se llama al método que busca la actividad por su ID
        $actividad = $IActividadDAO->getActividadById($id);
        return $actividad;
    }

    public function mostrar($actividadDTO){
        $user = application::getInstance()->getUserDTO();
        $tipo_user = $user->tipo();
        $html = '<div class="actividad">';
        $html .= '<img src="img/' . $actividadDTO->foto().  '" alt="' . $actividadDTO->nombre() . '">';
        $html .= '<h3>' . $actividadDTO->nombre() . '</h3>';
        $html .= '<p class="descripcion">' . $actividadDTO->descripcion() . '</p>';
        //usuario
        if ($tipo_user == 1){            
            $html .= '<a href="vistaReservaActividad.php?id=' . $actividadDTO->id() . '" class="btn">Reservar</a>';

        }
        //voluntario
        if ($tipo_user == 2){
            $html .= '<a href="vistaDirigirActividad.php?id=' . $actividadDTO->id() . '" class="btn">Dirigir</a>';

        }
        //administrador: dos botones
        if ($tipo_user == 0){
            //debe de aparecer un boton para eliminarla y otro para modificar los datos
            $html .= '<a href="ModificarActividad.php?id=' . $actividadDTO->id() . '" class="btn">Modificar</a>';
            $html .= '<a href="EliminarActividad.php?id=' . $actividadDTO->id() . '" class="btn">Eliminar</a>';
        }
        //$html .= '<a href="' . $this->getEnlace($tipo_usuario) . '" class="btn">' . ($tipo_usuario == 'usuario' ? 'Inscribirse' : 'Dirigir') . '</a>';
        
        $html .= '</div>';
        return $html;  //se devuelve en html
    }


    public function getActividadesUsuario($id_usuario)
    {
        $IActividadDAO = actividadesusuarioFactory::CreateActividad();

        $actividad = $IActividadDAO->getActividadesUsuario($id_usuario);

        return $actividad;
    }

    public function isRegistrado($id_usuario, $id_actividad){

        $IActividadesusuarioDAO = actividadesusuarioFactory::CreateActividad();
        $int=$IActividadesusuarioDAO->isRegistrado($id_usuario, $id_actividad);
        return $int;
    }


    public function apuntarUsuario($id_actividad, $id_usuario){
        $IActividadesusuarioDAO = actividadesusuarioFactory::CreateActividad();
        $IActividadesusuarioDAO->apuntarUsuario($id_actividad, $id_usuario);

    }

}
?>
