<?php

// Se incluye el archivo necesario para gestionar los datos de usuario
require_once __DIR__ . "/usuario/userDTO.php"; // Asegúrate de que la ruta sea correcta

// Clase principal que gestiona la aplicación
class application
{
    // Atributo estático para implementar el patrón Singleton
    private static $instancia;
    
    // Método para obtener la única instancia de la aplicación
    public static function getInstance() 
    {
        if (!self::$instancia instanceof self) {
            self::$instancia = new static();
        }
        return self::$instancia;
    }

    // Constructor privado para evitar instanciación directa (parte del patrón Singleton)
    private function __construct() {}

    // Variables para gestionar la conexión a la base de datos
    private $bdDatosConexion;
    private $inicializada = false;
    private $conn;

    // Atributos de sesión para almacenar datos de la petición
    private $atributosPeticion;
    const ATRIBUTOS_PETICION = 'attsPeticion';

    // Inicializa la aplicación con los datos de conexión a la base de datos
    public function init($bdDatosConexion)
    {
        if (!$this->inicializada) {
            $this->bdDatosConexion = $bdDatosConexion;
            $this->inicializada = true;
            
            // Inicia la sesión para gestionar datos entre peticiones
            session_start();

            // Carga los atributos de petición almacenados en la sesión
            $this->atributosPeticion = $_SESSION[self::ATRIBUTOS_PETICION] ?? [];
            
            // Limpia los atributos de la sesión después de usarlos
            unset($_SESSION[self::ATRIBUTOS_PETICION]);
        }
    }
    
    // Método para cerrar la aplicación correctamente
    public function shutdown()
    {
        $this->compruebaInstanciaInicializada();
        
        // Si hay una conexión activa con la base de datos, se cierra
        if ($this->conn !== null && !$this->conn->connect_errno) {
            $this->conn->close();
        }
    }
    
    // Verifica que la aplicación haya sido inicializada antes de usarla
    private function compruebaInstanciaInicializada()
    {
        if (!$this->inicializada) {
            echo "Aplicación no inicializada";
            exit();
        }
    }
    
    // Establece y devuelve la conexión a la base de datos
    public function getConexionBd()
    {
        $this->compruebaInstanciaInicializada();
        
        if (!$this->conn) {
            // Obtiene los datos de conexión desde la configuración
            $bdHost = $this->bdDatosConexion['host'];
            $bdUser = $this->bdDatosConexion['user'];
            $bdPass = $this->bdDatosConexion['pass'];
            $bd     = $this->bdDatosConexion['bd'];

            // Crea una conexión con la base de datos
            $conn = new mysqli($bdHost, $bdUser, $bdPass, $bd);
            
            // Verifica si hubo errores en la conexión
            if ($conn->connect_errno) {
                echo "Error de conexión a la BD ({$conn->connect_errno}):  {$conn->connect_error}";
                exit();
            }
            
            // Configura la codificación de caracteres de la base de datos
            if (!$conn->set_charset("utf8mb4")) {
                echo "Error al configurar la BD ({$conn->errno}):  {$conn->error}";
                exit();
            }
            
            $this->conn = $conn;
        }
        
        return $this->conn;
    }

    // Guarda un atributo en la sesión para su uso en futuras peticiones
    public function putAtributoPeticion($clave, $valor)
    {
        $atts = null;
        
        // Comprueba si ya existen atributos de petición en la sesión
        if (isset($_SESSION[self::ATRIBUTOS_PETICION])) {
            $atts = &$_SESSION[self::ATRIBUTOS_PETICION];
        } else {
            $atts = array();
            $_SESSION[self::ATRIBUTOS_PETICION] = &$atts;
        }

        // Almacena el atributo en la sesión
        $atts[$clave] = $valor;
    }

    // Recupera un atributo de petición almacenado en la sesión
    public function getAtributoPeticion($clave)
    {
        $result = $this->atributosPeticion[$clave] ?? null;
        
        // Si no se encuentra en la sesión actual, intenta recuperarlo de la sesión almacenada
        if (is_null($result) && isset($_SESSION[self::ATRIBUTOS_PETICION])) {
            $result = $_SESSION[self::ATRIBUTOS_PETICION][$clave] ?? null;
        }
        
        return $result;
    }

    // Guarda la información del usuario en la sesión
    public function setUserDTO($user)
    {
        $_SESSION["userDTO"] = serialize($user); // Serializa el objeto usuario antes de almacenarlo
    }

    // Verifica si el usuario actual tiene permisos de administrador
    public function soyAdmin()
    {
        $user = unserialize($_SESSION["userDTO"]); // Recupera el objeto usuario de la sesión
        return $user->tipo() === 0; // Comprueba si el tipo de usuario es 0 (administrador) 
    }

    public function soyVoluntario()
    {
        $user = unserialize($_SESSION["userDTO"]); // Recupera el objeto usuario de la sesión
        return $user->tipo() === 2; // Comprueba si el tipo de usuario es 2 (voluntario) //USAR ESTA FUNCION
    }

    public function soyUsuario()
    {
        $user = unserialize($_SESSION["userDTO"]); // Recupera el objeto usuario de la sesión
        return $user->tipo() === 1; // Comprueba si el tipo de usuario es 1 (usuario) //USAR ESTA FUNCION
    }

    // Obtiene la información del usuario almacenada en la sesión
    public function getUserDTO()
    {
        return unserialize($_SESSION["userDTO"]); // Recupera el objeto usuario
    }

    public function isUserLogged(): bool {
        return isset($_SESSION["login"]) && $_SESSION["login"];
    }
}