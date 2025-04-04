<?php

namespace includes\comun;

// Clase base para la gestión de formularios.
abstract class formBase
{
    private $formId;  // Identificador único del formulario.
    private $action;  // Acción del formulario (a dónde se envían los datos).

    // Constructor de la clase. Inicializa el formulario con un ID y opciones.
    public function __construct($formId, $opciones = array() )
    {
        $this->formId = $formId;

        // Establece las opciones por defecto del formulario.
        $opcionesPorDefecto = array( 'action' => null, );
        
        // Mergea las opciones pasadas con las por defecto.
        $opciones = array_merge($opcionesPorDefecto, $opciones);

        $this->action = $opciones['action'];
        
        // Si no se especifica acción, usa el archivo PHP actual.
        if ( !$this->action ) 
        {
            $this->action = htmlentities($_SERVER['PHP_SELF']);
        }
    }
  
    // Función principal que gestiona el formulario: creación o procesamiento.
    public function Manage()
    {   
        // Si el formulario no ha sido enviado, lo crea.
        if ( ! $this->IsSent($_POST) ) 
        {
            return $this->Create();
        } 
        else 
        {
            // Si fue enviado, lo procesa.
            $result = $this->Process($_POST);
            
            // Si el resultado es un array, crea el formulario con los datos de error.
            if ( is_array($result) ) 
            {
                return $this->Create($result, $_POST);
            } 
            else 
            {
                // Si el resultado es una URL, redirige al usuario a esa URL.
                header('Location: '.$result);
                exit();
            }
        }  
    }

    // Verifica si el formulario fue enviado (si contiene un campo "action" con el ID del formulario).
    private function IsSent(&$params)
    {
        return isset($params['action']) && $params['action'] == $this->formId;
    } 

    // Crea el HTML del formulario, incluyendo errores si los hay.
    private function Create($errores = array(), &$datos = array())
    {
        $html = $this->CreateErrors($errores);  // Muestra los errores si existen.

        // Crea el formulario con los campos necesarios.
        $html .= '<form method="POST" action="'.$this->action.'" id="'.$this->formId.'" enctype="multipart/form-data">';
        //$html .= '<form method="POST" action="'.$this->action.'" id="'.$this->formId.'" >';
        
        $html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

        $html .= $this->CreateFields($datos);  // Crea los campos del formulario.
        $html .= '</form>';
        
        return $html;
    }

    // Crea el HTML para mostrar los errores.
    private function CreateErrors($errores)
    {
        $html = '';
        $numErrores = count($errores);
        
        // Si hay errores, los muestra en una lista.
        if (  $numErrores == 1 ) 
        {
            $html .= "<ul><li>".$errores[0]."</li></ul>";
        } 
        else if ( $numErrores > 1 ) 
        {
            $html .= "<ul><li>";
            $html .= implode("</li><li>", $errores);
            $html .= "</li></ul>";
        }
        return $html;
    }

    // Método para crear los campos del formulario. Está vacío en la clase base, pero lo pueden implementar las clases hijas.
    protected function CreateFields($datosIniciales)
    {
        return '';
    }

    // Método para procesar los datos del formulario. Está vacío en la clase base, pero lo pueden implementar las clases hijas.
    protected function Process($datos)
    {
        return array();
    }
}
?>