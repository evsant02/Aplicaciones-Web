<?php 

namespace includes\login;

use includes\comun\formBase;
use includes\usuario\userAppService;
use includes\application;
use includes\usuario\userDTO;
use includes\excepciones\EmailAlreadyExistException;
use includes\excepciones\UserAlreadyExistException;
use includes\excepciones\UserNotFoundException;

// Incluye la clase base del formulario y el servicio de usuario
//include __DIR__ . "/../comun/formBase.php";
//include __DIR__ . "/../usuario/userAppService.php";

//require_once(__DIR__ . "/../../excepciones/user/UserAlreadyExistException.php");
//require_once(__DIR__ . "/../../excepciones/user/EmailAlreadyExistException.php");
//require_once(__DIR__ . "/../../excepciones/user/UserNotFoundException.php");

// Define la clase registerForm, que extiende formBase
class registerForm extends formBase
{
    public function __construct() 
    {
        // Llama al constructor de la clase base con el identificador 'registerForm'
        parent::__construct('registerForm');
    }
    
    // Método para generar los campos del formulario de registro
    protected function CreateFields($datos)
    {
        // Inicialización de variables con valores vacíos o por defecto
        $id = $nombre = $apellidos = $fechaNacimiento = $correo = $password = "";
        $tipo = "1"; // 1 para Usuario, 2 para Voluntario
        
        // Si se han enviado datos, se rellenan los campos
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

        // Genera el HTML del formulario de registro
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
    
    // Método que procesa los datos enviados en el formulario
    protected function Process($datos)
    {
        $result = array();
        
        // Obtiene y limpia los valores ingresados por el usuario
        $nombre = htmlspecialchars(trim($datos['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
        $apellidos = htmlspecialchars(trim($datos['apellidos'] ?? ''), ENT_QUOTES, 'UTF-8');
        $id = htmlspecialchars(trim($datos['id'] ?? ''), ENT_QUOTES, 'UTF-8');
        $fechaNacimiento = htmlspecialchars(trim($datos['fecha_nacimiento'] ?? ''), ENT_QUOTES, 'UTF-8');
        $correo = htmlspecialchars(trim($datos['correo'] ?? ''), ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars(trim($datos['password'] ?? ''), ENT_QUOTES, 'UTF-8');
        $tipo = htmlspecialchars(trim($datos['tipo'] ?? ''), ENT_QUOTES, 'UTF-8');
        $terminos = isset($datos['terminos']); // Verifica si se aceptaron los términos

        // Verificar si el checkbox de términos está marcado y si hay campos vacíos
        if ($terminos && (empty($id) || empty($nombre) || empty($apellidos) || empty($fechaNacimiento) || empty($correo) || empty($password))) 
        {
            $result[] = "Todos los campos son obligatorios.";
        }
        
        // Validar formato del correo
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) 
        {
            $result[] = "El correo electrónico no es válido.";
        }

        // Verificar edad mínima para registrarse como usuario (65 años o más)
        $fechaNacimientoObj = \DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        $edad = $fechaNacimientoObj ? $fechaNacimientoObj->diff(new \DateTime())->y : 0;

        if ($tipo == "2" && $edad < 18) {
            $result[] = "La edad necesaria para poder registrarse en el caso del voluntario es 18 años.";
        }
        
        if ($tipo == "2" && $edad < 18) {
            $result[] = "La edad necesaria para poder registrarse en el caso del voluntario es 18 años.";
        }

        if ($tipo == "1" && $edad < 65) {
            $result[] = "La edad necesaria para poder registrarse como usuario es a partir de los 65 años.";
        }

        // Crear un objeto de usuario solo con el ID y correo para verificar si ya existen
        $userDTO = new userDTO($id, null, null, null, null, null, $correo);
        $userAppService = userAppService::GetSingleton();

        // Verificar si ya existe un usuario con ese correo
       /* if ($userAppService->existsByEmail($userDTO)) {
            $result[] = "Ya existe una cuenta con este correo electrónico.";
        }

        // Verificar si el ID de usuario ya está en uso
        if ($userAppService->existsById($userDTO)) {
            $result[] = "El ID de usuario ya está en uso. Por favor, elige otro.";
        }*/

        try {
            // Verificar si ya existe un usuario con ese correo
            if ($userAppService->existsByEmail($userDTO)) {
                $result[] = "Ya existe una cuenta con este correo electrónico.";
            }
        } catch (EmailAlreadyExistException $e) {

            $result[] = $e->getMessage();
            
            //falta que se dirija a una pagina de vista de error (en a practica final)
        }
    
        try {
            // Verificar si el ID de usuario ya está en uso
            if ($userAppService->existsById($userDTO)) {
                $result[] = "El ID de usuario ya está en uso. Por favor, elige otro.";
            }
        } catch (UserNotFoundException $e) {

            $result[] = $e->getMessage();

        }
    

        // Si no hay errores, se procede con el registro
        if (count($result) === 0) 
        {
            try
            {
                // Crear un nuevo objeto usuario con todos los datos ingresados
                $userDTO = new userDTO($id, $nombre, $apellidos, $password, $fechaNacimiento, $tipo, $correo);
                $createdUserDTO = $userAppService->create($userDTO);

                // Guardar el usuario en la sesión
                application::getInstance()->setUserDTO($userDTO);
                $_SESSION["login"] = true;

                // Redirigir a la página principal
                $result = 'index.php';

                // Mensaje de bienvenida tras el registro
                $app = application::getInstance();
                $mensaje = "Se ha registrado exitosamente, Bienvenido {$nombre}";
                $app->putAtributoPeticion('mensaje', $mensaje);
            }
            catch(UserAlreadyExistException $e)
            {
                // Captura el error si el usuario ya existe
                $result[] = $e->getMessage();
            }
        }

        return $result;
    }
}