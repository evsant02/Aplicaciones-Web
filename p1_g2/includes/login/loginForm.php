<?php

include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../usuario/userAppService.php";

class loginForm extends formBase
{
    public function __construct() 
    {
        parent::__construct('loginForm');
    }
    
    protected function CreateFields($datos)
    {
        $id = $datos['id'] ?? '';
        $password = $datos['password'] ?? '';

        $html = <<<EOF
        <fieldset>
            <legend>Iniciar sesión</legend>
            <p><label>Nombre de usuario:</label> <input type="text" name="id" value="$id" required/></p>
            <p><label>Contraseña:</label> <input type="password" name="password" value="$password" required/></p>
            <button type="submit" name="login">Entrar</button>

            <p>¿No tienes cuenta?</p>
            <a href="register.php"><button type="button">Regístrate</button></a>
        </fieldset>
EOF;
        return $html;
    }

    //
    
    protected function Process($datos)
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
                application::getInstance()->setUserDTO($foundedUserDTO);

                // Iniciar sesión
                $_SESSION["login"] = true;
                //$_SESSION["tipo"] = $foundedUserDTO->tipo();
                //$_SESSION["nombre"] = $foundedUserDTO->nombre();
                //$_SESSION["id"] = $id;

                // Redirigir a la página principal
                $result = 'contenido.php';
            }
        }

        // Si hay errores, devolver los datos y los mensajes de error para mostrarlos en el formulario
        return $result;
    }
}