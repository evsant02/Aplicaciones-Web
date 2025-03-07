<?php

include __DIR__ . "/../comun/formBase.php";

class ayudaForm extends formBase {
    public function __construct() {
        parent::__construct('ayudaForm');
    }

    protected function CreateFields($datos) {

      $html = <<<EOF
      <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required>
        
        <br><br>
        
        <label for="email">Dirección de email:</label><br>
        <input type="email" id="email" name="email" required>
        
        <br><br>
        
        <fieldset>
            <legend>Motivo de la consulta:</legend>
            <input type="radio" id="evaluacion" name="motivo" value="Evaluación" required>
            <label for="evaluacion">Evaluación</label>
            
            <input type="radio" id="sugerencias" name="motivo" value="Sugerencias">
            <label for="sugerencias">Sugerencias</label>
            
            <input type="radio" id="criticas" name="motivo" value="Críticas">
            <label for="criticas">Críticas</label>
        </fieldset>
        
        <br>
        
        <label for="consulta">Escriba su consulta:</label><br>
        <textarea id="consulta" name="consulta" rows="4" cols="80" required></textarea>
        
        <br><br>
        
        <input type="checkbox" id="terminos" name="terminos" required>
        <label for="terminos">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio</label>
        
        <br><br>
                
        <input type="reset" name="borrar" value="Borrar formulario">
        <input type="submit" name="enviar" value="Enviar">
      EOF;
    
      return $html;

    }

    /*protected function Process($datos)
    {
      $result = array();
      
      $id = trim($datos['id'] ?? '');
      $password = trim($datos['password'] ?? '');
      
      // Validar que el ID y la contraseña no estén vacíos
      if (empty($id)) 
      {
          $result[] = "El ID de usuario no puede estar vacío.";
      }
      
      if (empty($password)) 
      {
          $result[] = "La contraseña no puede estar vacía.";
      }
      
      if (count($result) === 0) 
      {

          $userDTO = new userDTO($id, null, null, $password, null, null, null);
          
          $userAppService = userAppService::GetSingleton();

          // Verificar si existe un usuario con ese ID y contraseña
          $foundedUserDTO = $userAppService->login($userDTO);

          if (!$foundedUserDTO) 
          {
              $result[] = "No existe una cuenta con ese ID y contraseña. Por favor, regístrate.";
          } 
          else 
          {
              // Iniciar sesión
              $_SESSION["login"] = true;
              $_SESSION["id"] = $id;

              // Redirigir a la página principal
              $result = 'contenido.php';
          }
      }

      // Si hay errores, devolver los datos y los mensajes de error para mostrarlos en el formulario
      return $result;
  }*/

}

?>