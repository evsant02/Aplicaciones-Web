<?php
// Se incluyen archivos necesarios
include __DIR__ . "/../actividad/actividadAppService.php";

// Clase que gestiona la lista de actividades
class listaActividades 
{
    // Método que genera la interfaz de la lista de actividades
    public function generarListado()
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
}
