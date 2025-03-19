<?php

include __DIR__ . "/../comun/formBase.php";

class donarForm extends formBase {
    public function __construct() {
        parent::__construct('donarForm');
    }

    protected function CreateFields($datos) {

      $html = <<<EOF
      <fieldset>
          <p><label>Cantidad:</label> <input type="number" name="cantidad"/> €</p> 
          <p><label>IBAN:</label> <input type="text" name="iban" /></p>
          <p><label>Nombre:</label> <input type="text" name="name" /></p>
          <p><label>Apellidos:</label> <input type="text" name="surname" /></p>
          <p>
            <input type="checkbox" id="anonimo" name="anonimo" value="anonimo">
            <label id="checkbox">Realizar la donación de manera anónima</label>
          </p>
          <button type="submit">Donar</button>
      </fieldset>
      EOF;
    
      return $html;

    }
    // todavía no se implementa la funcionalidad
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