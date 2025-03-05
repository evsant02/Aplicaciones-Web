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
        $nombre = $apellidos = $fechaNacimiento = $correo = $password = "";
        $tipo = "1"; // 1 para Usuario, 2 para Voluntario
        
        if ($datos) 
        {
            $nombre = isset($datos['nombre']) ? $datos['nombre'] : $nombre;
            $apellidos = isset($datos['apellidos']) ? $datos['apellidos'] : $apellidos;
            $fechaNacimiento = isset($datos['fecha_nacimiento']) ? $datos['fecha_nacimiento'] : $fechaNacimiento;
            $correo = isset($datos['correo']) ? $datos['correo'] : $correo;
            $password = isset($datos['password']) ? $datos['password'] : $password;
            $tipo = isset($datos['tipo']) ? $datos['tipo'] : $tipo;
        }

        $html = <<<EOF
        <fieldset>
            <legend>Registro de Usuario</legend>
            <p><label>Nombre:</label> <input type="text" name="nombre" value="$nombre"/></p>
            <p><label>Apellidos:</label> <input type="text" name="apellidos" value="$apellidos"/></p>
            <p><label>Fecha de nacimiento:</label> <input type="date" name="fecha_nacimiento" value="$fechaNacimiento"/></p>
            <p><label>Correo electrónico:</label> <input type="email" name="correo" value="$correo"/></p>
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
EOF;
        return $html;
    }
    
    protected function Process($datos)
    {
        $result = array();
        
        $nombre = trim($datos['nombre'] ?? '');
        $apellidos = trim($datos['apellidos'] ?? '');
        $fechaNacimiento = trim($datos['fecha_nacimiento'] ?? '');
        $correo = trim($datos['correo'] ?? '');
        $password = trim($datos['password'] ?? '');
        $tipo = trim($datos['tipo'] ?? '');
        $terminos = isset($datos['terminos']) ? true : false;

        // Verificar si el checkbox de términos está marcado pero hay campos vacíos
        if ($terminos && (empty($nombre) || empty($apellidos) || empty($fechaNacimiento) || empty($correo) || empty($password))) 
        {
            $result[] = "Todos los campos son obligatorios.";
        }
        
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) 
        {
            $result[] = "El correo electrónico no es válido.";
        }

        $fechaNacimientoObj = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        $edad = $fechaNacimientoObj ? $fechaNacimientoObj->diff(new DateTime())->y : 0;
        
        if ($tipo == "1" && $edad < 65) {
            $result[] = "La edad necesaria para poder registrarse como usuario es a partir de los 65 años.";
        }
        
        $userAppService = userAppService::GetSingleton();
        
        if ($userAppService->existsByEmail($correo)) {
            $result[] = "Ya existe una cuenta con este correo electrónico.";
        }
        
        if (count($result) === 0) 
        {
            try
            {
                $userDTO = new userDTO(0, $nombre, $apellidos, $fechaNacimiento, $correo, $password, $tipo);
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