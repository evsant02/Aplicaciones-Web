<?php
include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../actividad/actividadAppService.php";

class listaActividades extends formBase
{
    public function __construct() 
    {
        parent::__construct('listaActividades');
    }

    protected function CreateFields($datos)
    {
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

        // Obtener la lista de actividades
        $actividadAppService = actividadAppService::GetSingleton();
        $actividades = $actividadAppService->obtenerTodasLasActividades();

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

        $html .= "</table>";

        return $html;
    }

    protected function Process($datos)
    {
        // No se necesita procesamiento
        return [];
    }
}
?>
