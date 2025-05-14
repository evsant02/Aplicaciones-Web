<?php 

namespace includes\login;

use includes\comun\formBase;
use includes\usuario\userAppService;
use includes\application;
use includes\usuario\userDTO;
use includes\excepciones\EmailAlreadyExistException;
use includes\excepciones\UserAlreadyExistException;
use includes\excepciones\UserNotFoundException;

// Define la clase registerForm, que extiende formBase
class registerForm extends formBase
{
    public function __construct() 
    {
        parent::__construct('registerForm');
    }
    
    protected function CreateFields($datos)
    {
        $id = $nombre = $apellidos = $fechaNacimiento = $correo = $password = "";
        $tipo = "1"; // 1 para Usuario, 2 para Voluntario
        
        if ($datos) 
        {
            $nombre = $datos['nombre'] ?? $nombre;
            $apellidos = $datos['apellidos'] ?? $apellidos;
            $id = $datos['id'] ?? $id;
            $fechaNacimiento = $datos['fecha_nacimiento'] ?? $fechaNacimiento;
            $correo = $datos['correo'] ?? $correo;
            $password = $datos['password'] ?? $password;
            $tipo = $datos['tipo'] ?? $tipo;
        }

        $html = <<<EOF
            <div class="inForm">
                <fieldset>
                    <p><label>Nombre:</label> <input type="text" name="nombre" value="$nombre" required/></p>
                    <p><label>Apellidos:</label> <input type="text" name="apellidos" value="$apellidos" required/></p>
                    <p><label>Nombre de Usuario:</label> <input type="text" name="id" value="$id" required/></p>
                    <p><label>Fecha de nacimiento:</label> <input type="date" name="fecha_nacimiento" value="$fechaNacimiento" required/></p>
                    <p><label>Correo electrónico:</label> <input type="email" name="correo" value="$correo" required/></p>
                    <p><label>Contraseña:</label> <input type="password" name="password" /></p>
                    <p><label>Tipo de cuenta:</label>
                        <select name="tipo">
                            <option value="1" " . ($tipo == "1" ? "selected" : "") . ">Usuario</option>
                            <option value="2" " . ($tipo == "2" ? "selected" : "") . ">Voluntario</option>
                        </select>
                    </p>
                    <p>
                        <input type="checkbox" name="terminos" required> Acepto los Términos y Condiciones
                    </p>
                    <button type="submit" name="registro">Crear cuenta</button>
                </fieldset>
            </div>
        EOF;

        return $html;
    }
    
    protected function Process($datos)
    {
        $result = array();
        
        $nombre = htmlspecialchars(trim($datos['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
        $apellidos = htmlspecialchars(trim($datos['apellidos'] ?? ''), ENT_QUOTES, 'UTF-8');
        $id = htmlspecialchars(trim($datos['id'] ?? ''), ENT_QUOTES, 'UTF-8');
        $fechaNacimiento = htmlspecialchars(trim($datos['fecha_nacimiento'] ?? ''), ENT_QUOTES, 'UTF-8');
        $correo = htmlspecialchars(trim($datos['correo'] ?? ''), ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars(trim($datos['password'] ?? ''), ENT_QUOTES, 'UTF-8');
        $tipo = htmlspecialchars(trim($datos['tipo'] ?? ''), ENT_QUOTES, 'UTF-8');
        $terminos = isset($datos['terminos']);

        if ($terminos && (empty($id) || empty($nombre) || empty($apellidos) || empty($fechaNacimiento) || empty($correo) || empty($password))) 
        {
            $result[] = "Todos los campos son obligatorios.";
        }
        
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) 
        {
            $result[] = "El correo electrónico no es válido.";
        }

        $fechaNacimientoObj = \DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        $edad = $fechaNacimientoObj ? $fechaNacimientoObj->diff(new \DateTime())->y : 0;
        
        if ($tipo == "2" && $edad < 18) {
            $result[] = "La edad necesaria para poder registrarse en el caso del voluntario es 18 años.";
        }

        if ($tipo == "1" && $edad < 65) {
            $result[] = "La edad necesaria para poder registrarse como usuario es a partir de los 65 años.";
        }

        $userDTO = new userDTO($id, null, null, null, null, null, $correo);
        $userAppService = userAppService::GetSingleton();

        try {
            if ($userAppService->existsByEmail($userDTO)) {
                $result[] = "Ya existe una cuenta con este correo electrónico.";
            }
        } catch (EmailAlreadyExistException $e) {
            header("Location: error404.php");
            exit();
        }

        try {
            if ($userAppService->existsById($userDTO)) {
                $result[] = "El ID de usuario ya está en uso. Por favor, elige otro.";
            }
        } catch (UserNotFoundException $e) {
            header("Location: error404.php");
            exit();
        }

        if (count($result) === 0) 
        {
            try
            {
                $userDTO = new userDTO($id, $nombre, $apellidos, $password, $fechaNacimiento, $tipo, $correo);
                $createdUserDTO = $userAppService->create($userDTO);

                application::getInstance()->setUserDTO($userDTO);
                $_SESSION["login"] = true;

                $result = 'index.php';

                $app = application::getInstance();
                $mensaje = "Se ha registrado exitosamente";
                $app->putAtributoPeticion('mensaje', $mensaje);
            }
            catch(UserAlreadyExistException $e)
            {
                header("Location: error404.php");
                exit();
            }
        }

        return $result;
    }
}
