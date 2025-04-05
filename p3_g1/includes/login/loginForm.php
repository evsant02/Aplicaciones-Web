<?php

namespace includes\login;

use includes\comun\formBase;
use includes\usuario\userAppService;
use includes\application;
use includes\usuario\userDTO;

// Incluye la clase base del formulario y el servicio de usuario
//include __DIR__ . "/../comun/formBase.php";
//include __DIR__ . "/../usuario/userAppService.php";

// Define la clase loginForm, que extiende formBase
class loginForm extends formBase
{
    public function __construct() 
    {
        // Llama al constructor de la clase base y asigna el nombre 'loginForm'
        parent::__construct('loginForm');
    }
    
    // Método para generar los campos del formulario de login
    protected function CreateFields($datos)
    {
        // Obtiene los valores de los campos (si existen) para rellenarlos en caso de error
        $id = $datos['id'] ?? '';
        $password = $datos['password'] ?? '';

        // Genera el HTML del formulario
        $html = <<<EOF
            <div class="inForm">
                <fieldset>
                    <legend>Iniciar sesión</legend>
                    <p><label>Nombre de usuario:</label> <input type="text" name="id" value="$id" required/></p>
                    <p><label>Contraseña:</label> <input type="password" name="password" value="$password" required/></p>
                    <button type="submit" name="login">Entrar</button>
                    <div class="linea-separadora-usuario"></div>
                    <p>¿No tienes cuenta?</p>
                    <a href="register.php"><button type="button">Regístrate</button></a>
                </fieldset>
            </div>
        EOF;
        return $html;
    }

    // Método que procesa los datos enviados en el formulario
    protected function Process($datos)
    {
        $result = array();
        
        // Obtiene y limpia los valores ingresados por el usuario
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
        
        // Si no hay errores, intenta autenticar al usuario
        if (count($result) === 0) 
        {
            // Crea un objeto de usuario con los datos ingresados
            $userDTO = new userDTO($id, null, null, $password, null, null, null);
            
            // Obtiene la instancia del servicio de autenticación de usuarios
            $userAppService = userAppService::GetSingleton();

            // Intenta iniciar sesión con el usuario ingresado
            $foundedUserDTO = $userAppService->login($userDTO);

            if (!$foundedUserDTO) 
            {
                // Si no encuentra el usuario, muestra un mensaje de error
                $result[] = "No existe una cuenta con ese ID y contraseña. Por favor, regístrate.";
            } 
            else 
            {
                // Si el usuario es válido, guarda su información en la sesión
                application::getInstance()->setUserDTO($foundedUserDTO);

                $_SESSION["login"] = true;
                //$_SESSION["tipo"] = $foundedUserDTO->tipo();
                //$_SESSION["nombre"] = $foundedUserDTO->nombre();
                //$_SESSION["id"] = $id;

                // Redirigir a la página principal
                $result = 'perfil.php';
            }
        }

        // Devuelve el resultado, ya sea la redirección o los errores
        return $result;
    }
}
