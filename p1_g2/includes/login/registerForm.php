<?php 

include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../usuario/userAppService.php";

class registerForm extends formBase
{
    public function __construct() 
    {
        parent::__construct('registerForm');
    }
    
    protected function CreateFields($datos)
    {
        $nombre = $apellidos = $fechaNacimiento = $correo = $nombreUsuario = $password = $rePassword = "";
        $tipoCuenta = "Usuario";
        
        if ($datos) 
        {
            $nombre = isset($datos['nombre']) ? $datos['nombre'] : $nombre;
            $apellidos = isset($datos['apellidos']) ? $datos['apellidos'] : $apellidos;
            $fechaNacimiento = isset($datos['fechaNacimiento']) ? $datos['fechaNacimiento'] : $fechaNacimiento;
            $correo = isset($datos['correo']) ? $datos['correo'] : $correo;
            $nombreUsuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : $nombreUsuario;
            $password = isset($datos['password']) ? $datos['password'] : $password;
            $rePassword = isset($datos['rePassword']) ? $datos['rePassword'] : $rePassword;
            $tipoCuenta = isset($datos['tipoCuenta']) ? $datos['tipoCuenta'] : $tipoCuenta;
        }

        $html = <<<EOF
        <fieldset>
            <legend>Registro de Usuario</legend>
            <p><label>Nombre:</label> <input type="text" name="nombre" value="$nombre"/></p>
            <p><label>Apellidos:</label> <input type="text" name="apellidos" value="$apellidos"/></p>
            <p><label>Nombre de Usuario:</label> <input type="text" name="nombreUsuario" value="$nombreUsuario"/></p>
            <p><label>Fecha de nacimiento:</label> <input type="date" name="fechaNacimiento" value="$fechaNacimiento"/></p>
            <p><label>Correo electrónico:</label> <input type="email" name="correo" value="$correo"/></p>
            <p><label>Contraseña:</label> <input type="password" name="password" /></p>
            <p><label>Repetir contraseña:</label> <input type="password" name="rePassword" /></p>
            <p><label>Tipo de cuenta:</label>
                <select name="tipoCuenta">
                    <option value="Usuario" " . ($tipoCuenta == "Usuario" ? "selected" : "") . ">Usuario</option>
                    <option value="Voluntario" " . ($tipoCuenta == "Voluntario" ? "selected" : "") . ">Voluntario</option>
                </select>
            </p>
            <p>
                <input type="checkbox" name="terminos" required> Acepto los Términos y Condiciones
            </p>
            <button type="submit" name="registro">Crear cuenta</button>
        </fieldset>
EOF;
        return $html;
    }
    
    protected function Process($datos)
    {
        $result = array();
        
        $nombre = trim($datos['nombre'] ?? '');
        $apellidos = trim($datos['apellidos'] ?? '');
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $fechaNacimiento = trim($datos['fechaNacimiento'] ?? '');
        $correo = trim($datos['correo'] ?? '');
        $password = trim($datos['password'] ?? '');
        $rePassword = trim($datos['rePassword'] ?? '');
        $tipoCuenta = trim($datos['tipoCuenta'] ?? '');

        if (empty($nombre) || empty($apellidos) || empty($nombreUsuario) || empty($fechaNacimiento) || empty($correo) || empty($password) || empty($rePassword)) 
        {
            $result[] = "Todos los campos son obligatorios.";
        }
        
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) 
        {
            $result[] = "El correo electrónico no es válido.";
        }
        
        if ($password !== $rePassword) 
        {
            $result[] = "Las contraseñas no coinciden.";
        }

        $fechaNacimientoObj = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        $edad = $fechaNacimientoObj ? $fechaNacimientoObj->diff(new DateTime())->y : 0;
        
        if ($tipoCuenta == "Usuario" && $edad < 65) {
            $result[] = "La edad necesaria para poder registrarse como usuario es a partir de los 65 años.";
        }
        
        $userAppService = userAppService::GetSingleton();
        
        if ($userAppService->existsByUsername($nombreUsuario)) {
            $result[] = "El nombre de usuario ya existe.";
        }
        
        if ($userAppService->existsByEmail($correo)) {
            $result[] = "Ya existe una cuenta con este correo electrónico.";
        }
        
        if (count($result) === 0) 
        {
            try
            {
                $userDTO = new userDTO(0, $nombre, $apellidos, $nombreUsuario, $fechaNacimiento, $correo, $password, $tipoCuenta);
                $createdUserDTO = $userAppService->create($userDTO);

                $_SESSION["login"] = true;
                $_SESSION["nombre"] = $nombre;

                $result = 'index.php';

                $app = application::getInstance();
                $mensaje = "Se ha registrado exitosamente, Bienvenido {$nombre}";
                $app->putAtributoPeticion('mensaje', $mensaje);
            }
            catch(userAlreadyExistException $e)
            {
                $result[] = $e->getMessage();
            }
        }

        return $result;
    }
}