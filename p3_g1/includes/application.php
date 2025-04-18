<?php

namespace includes;

use includes\usuario\userDTO;

class application
{
    // Atributo estático para implementar el patrón Singleton
    private static $instancia;
    
    // Variables para gestionar la conexión a la base de datos
    private $bdDatosConexion;
    private $inicializada = false;
    private $conn;

    // Atributos de sesión para almacenar datos de la petición
    private $atributosPeticion;
    const ATRIBUTOS_PETICION = 'attsPeticion';

    // Método para obtener la única instancia de la aplicación
    public static function getInstance() 
    {
        if (!self::$instancia instanceof self) {
            self::$instancia = new static();
        }
        return self::$instancia;
    }

    // Constructor privado para evitar instanciación directa
    private function __construct() {}

    /**
     * Inicializa la aplicación con los datos de conexión a la base de datos
     * @param array $bdDatosConexion Array con los datos de conexión
     */
    public function init($bdDatosConexion)
    {
        if (!$this->inicializada) {
            session_start();
            
            // Limpiar sesión si hay datos inconsistentes
            if (isset($_SESSION["userDTO"]) && !isset($_SESSION["login"])) {
                unset($_SESSION["userDTO"]);
            }
            
            $this->bdDatosConexion = $bdDatosConexion;
            $this->inicializada = true;
            $this->atributosPeticion = $_SESSION[self::ATRIBUTOS_PETICION] ?? [];
            unset($_SESSION[self::ATRIBUTOS_PETICION]);
        }
    }
    
    /**
     * Cierra la aplicación correctamente
     */
    public function shutdown()
    {
        $this->compruebaInstanciaInicializada();
        
        if ($this->conn !== null && !$this->conn->connect_errno) {
            $this->conn->close();
        }
    }
    
    /**
     * Verifica que la aplicación haya sido inicializada
     */
    private function compruebaInstanciaInicializada()
    {
        if (!$this->inicializada) {
            throw new \RuntimeException("Aplicación no inicializada");
        }
    }
    
    /**
     * Obtiene la conexión a la base de datos
     * @return \mysqli Objeto de conexión MySQLi
     */
    public function getConexionBd()
    {
        $this->compruebaInstanciaInicializada();
        
        if (!$this->conn) {
            $bdHost = $this->bdDatosConexion['host'];
            $bdUser = $this->bdDatosConexion['user'];
            $bdPass = $this->bdDatosConexion['pass'];
            $bd     = $this->bdDatosConexion['bd'];

            $conn = new \mysqli($bdHost, $bdUser, $bdPass, $bd);
            
            if ($conn->connect_errno) {
                throw new \RuntimeException("Error de conexión a la BD ({$conn->connect_errno}): {$conn->connect_error}");
            }
            
            if (!$conn->set_charset("utf8mb4")) {
                throw new \RuntimeException("Error al configurar la BD ({$conn->errno}): {$conn->error}");
            }
            
            $this->conn = $conn;
        }
        
        return $this->conn;
    }

    /**
     * Almacena un atributo para la próxima petición
     * @param string $clave Clave del atributo
     * @param mixed $valor Valor del atributo
     */
    public function putAtributoPeticion($clave, $valor)
    {
        if (!isset($_SESSION[self::ATRIBUTOS_PETICION])) {
            $_SESSION[self::ATRIBUTOS_PETICION] = [];
        }
        $_SESSION[self::ATRIBUTOS_PETICION][$clave] = $valor;
    }

    /**
     * Obtiene un atributo almacenado para la petición
     * @param string $clave Clave del atributo
     * @return mixed Valor del atributo o null si no existe
     */
    public function getAtributoPeticion($clave)
    {
        $result = $this->atributosPeticion[$clave] ?? null;
        
        if (is_null($result) && isset($_SESSION[self::ATRIBUTOS_PETICION])) {
            $result = $_SESSION[self::ATRIBUTOS_PETICION][$clave] ?? null;
        }
        
        return $result;
    }

    /**
     * Almacena el DTO de usuario en la sesión
     * @param userDTO $user Objeto userDTO a almacenar
     * @throws \InvalidArgumentException Si no recibe un userDTO válido
     */
    public function setUserDTO($user)
    {
        if (!$user instanceof userDTO) {
            throw new \InvalidArgumentException("El parámetro debe ser una instancia de userDTO");
        }
        
        // Asegurar que la clase está disponible para serialización
        if (!class_exists('includes\usuario\userDTO')) {
            spl_autoload_call('includes\usuario\userDTO');
        }
        
        $_SESSION["userDTO"] = serialize($user);
        $_SESSION["login"] = true;
    }

    /**
     * Obtiene el DTO de usuario de la sesión
     * @return userDTO|null Objeto userDTO o null si no existe
     */
    public function getUserDTO(): ?userDTO
    {
        if (!isset($_SESSION["userDTO"])) {
            return null;
        }

        // Asegurar que la clase está cargada
        if (!class_exists('includes\usuario\userDTO')) {
            spl_autoload_call('includes\usuario\userDTO');
        }

        try {
            $user = unserialize($_SESSION["userDTO"]);
            return ($user instanceof userDTO) ? $user : null;
        } catch (\Exception $e) {
            error_log("Error al deserializar userDTO: " . $e->getMessage());
            unset($_SESSION["userDTO"]);
            return null;
        }
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout()
    {
        unset($_SESSION["userDTO"]);
        unset($_SESSION["login"]);
        session_destroy();
    }

    /**
     * Verifica si el usuario es administrador
     * @return bool True si es admin, false en caso contrario
     */
    public function soyAdmin(): bool
    {
        $user = $this->getUserDTO();
        return $user !== null && $user->tipo() === 0;
    }

    /**
     * Verifica si el usuario es voluntario
     * @return bool True si es voluntario, false en caso contrario
     */
    public function soyVoluntario(): bool
    {
        $user = $this->getUserDTO();
        return $user !== null && $user->tipo() === 2;
    }

    /**
     * Verifica si el usuario es normal
     * @return bool True si es usuario normal, false en caso contrario
     */
    public function soyUsuario(): bool
    {
        $user = $this->getUserDTO();
        return $user !== null && $user->tipo() === 1;
    }

    /**
     * Verifica si hay un usuario logueado
     * @return bool True si hay usuario logueado, false en caso contrario
     */
    public function isUserLogged(): bool
    {
        return isset($_SESSION["login"]) && $_SESSION["login"] && $this->getUserDTO() !== null;
    }
}