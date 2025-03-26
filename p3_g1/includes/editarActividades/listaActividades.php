<?php
// Se incluyen archivos necesarios: la base de formularios y el servicio de actividades
include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../actividad/actividadAppService.php";

// Clase que gestiona la lista de actividades, no tiene que extender de formBase
class listaActividades extends formBase
{
    // Constructor: inicializa la clase con un identificador único
    public function __construct() 
    {
        parent::__construct('listaActividades');
    }

    // Método que genera la interfaz de la lista de actividades
    protected function CreateFields($datos)
    {
        // Encabezado de la sección
        $html = <<<EOF
        <h2>Lista de Actividades</h2>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Localización</th>
                <th>Fecha y Hora</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
EOF;

        // Obtener la lista de actividades desde la base de datos
        $actividadAppService = actividadAppService::GetSingleton();
        $actividades = $actividadAppService->obtenerTodasLasActividades();

        // Recorrer las actividades y agregarlas a la tabla
        foreach ($actividades as $actividad) {
            $html .= "<tr>";
            $html .= "<td>" . htmlspecialchars($actividad->nombre()) . "</td>";
            $html .= "<td>" . htmlspecialchars($actividad->localizacion()) . "</td>";
            $html .= "<td>" . htmlspecialchars($actividad->fecha_hora()) . "</td>";
            $html .= "<td>" . htmlspecialchars($actividad->descripcion()) . "</td>";
            $html .= "<td>
                        <a href='ModificarActividad.php?id=" . $actividad->id() . "'>Modificar</a> |
                        <a href='EliminarActividad.php?id=" . $actividad->id() . "'>Eliminar</a>
                        </td>";
            $html .= "</tr>";
        }

        // Cierre de la tabla
        $html .= "</table>";

        return $html;
    }

    // Método de procesamiento (no se necesita en este caso)
    protected function Process($datos)
    {
        return [];
    }
}
?>
