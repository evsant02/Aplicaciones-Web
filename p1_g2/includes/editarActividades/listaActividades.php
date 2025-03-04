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
            $html .= "<td>" . htmlspecialchars($actividad->getNombre()) . "</td>";
            $html .= "<td>" . htmlspecialchars($actividad->getLocalizacion()) . "</td>";
            $html .= "<td>" . htmlspecialchars($actividad->getFechaHora()) . "</td>";
            $html .= "<td>" . htmlspecialchars($actividad->getDescripcion()) . "</td>";
            $html .= "<td>
                        <a href='ModificarActividad.php?id=" . $actividad->getId() . "'>Modificar</a> |
                        <a href='eliminarActividad.php?id=" . $actividad->getId() . "' onclick='return confirm(\"¿Seguro que quieres eliminar esta actividad?\")'>Eliminar</a>
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
