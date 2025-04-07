<?php

// Incluir la configuración principal de la aplicación
//require_once("application.php");

namespace includes;

error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Autoload de clases según PSR-4
 */
spl_autoload_register(function ($class) {
    // Mapeo de namespaces a directorios
    $prefixes = [
        'includes\\' => __DIR__ . '/',
        'includes\\usuario\\' => __DIR__ . '/usuario/',
        'includes\\comun\\' => __DIR__ . '/comun/',
        'includes\\actividadesusuario\\' => __DIR__ . '/actividades-usuario/',
        'includes\\mostrarPerfil\\' => __DIR__ . '/mostrarPerfil/',
        'includes\\actividad\\' => __DIR__ . '/actividad/',
        'includes\\ayuda\\' => __DIR__ . '/ayuda/',
        'includes\\crearActividad\\' => __DIR__ . '/crearActividad/',
        'includes\\dirigirActividad\\' => __DIR__ . '/dirigirActividad/',
        'includes\\donar\\' => __DIR__ . '/donar/',
        'includes\\login\\' => __DIR__ . '/login/',
        'includes\\modificarActividad\\' => __DIR__ . '/modificarActividad/',
        'includes\\mostrarActividades\\' => __DIR__ . '/mostrarActividades/',
        'includes\\reservarActividad\\' => __DIR__ . '/reservarActividad/',
        'includes\\excepciones\\' => __DIR__ . '/excepciones/'
    ];
    
    foreach ($prefixes as $prefix => $base_dir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) === 0) {
            $relative_class = substr($class, $len);
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
            
            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
});

// Definir constantes de conexión a la base de datos
define('BD_HOST', 'localhost'); //vm017.db.swarm.test
define('BD_NAME', 'aw');        // Nombre de la base de datos
define('BD_USER', 'AW');        // Usuario de la base de datos
define('BD_PASS', 'Conecta65'); // Contraseña de la base de datos

// Configuración del entorno
ini_set('default_charset', 'UTF-8');  // Establece la codificación a UTF-8
setLocale(LC_ALL, 'es_ES.UTF.8');     // Configura la localización en español
date_default_timezone_set('Europe/Madrid'); // Configura la zona horaria

// Obtener la instancia de la aplicación e inicializar la conexión a la base de datos
$app = application::getInstance();
$app->init(array(
    'host' => BD_HOST,
    'bd'   => BD_NAME,
    'user' => BD_USER,
    'pass' => BD_PASS
));

// Registrar la función de apagado para asegurar el cierre correcto de la aplicación
register_shutdown_function([$app, 'shutdown']);

// Función para gestionar excepciones no controladas
function gestorExcepciones(\Throwable $exception) 
{
    error_log(jTraceEx($exception)); // Registrar el error en el log del servidor

    http_response_code(500); // Devolver código de error 500 (Error interno del servidor)

    $tituloPagina = 'Error';
    //var_dump($exception->getMessage());
    // Mensaje de error para el usuario
    $contenidoPrincipal = <<<EOS
    <h1>Oops</h1>
    <p> Parece que ha habido un fallo.</p>
    EOS;

    require("comun/plantilla.php"); // Mostrar la plantilla de error
}

/*function gestorExcepciones($exception) {
    error_log(jTraceEx($exception)); // Registrar error en log
    http_response_code(500); // Código 500

    // Mensaje para el usuario (ejemplo)
    $mensajeUsuario = "Error: " . htmlspecialchars($exception->getMessage());

    // Incluir plantilla y mostrar mensaje
    require("comun/plantilla.php");
    #contenidoPrincipal = <<<EOS
    <h1>Oops</h1>
    <p>$mensajeUsuario</p>
    EOS;
}*/

// Registrar la función para manejar excepciones globales
set_exception_handler(__NAMESPACE__ . '\gestorExcepciones');

// Función que genera un rastreo detallado de la excepción
function jTraceEx($e, $seen = null) 
{
    $starter = $seen ? 'Caused by: ' : '';
    $result = array();
    if (!$seen) $seen = array();
    $trace  = $e->getTrace();
    $prev   = $e->getPrevious();
    $result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
    
    $file = $e->getFile();
    $line = $e->getLine();
    
    while (true) {
        $current = "$file:$line";
        if (is_array($seen) && in_array($current, $seen)) {
            $result[] = sprintf(' ... %d more', count($trace) + 1);
            break;
        }
        $result[] = sprintf(' at %s%s%s(%s%s%s)',
            count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '',
            count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '',
            count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)',
            $line === null ? $file : basename($file),
            $line === null ? '' : ':',
            $line === null ? '' : $line
        );
        if (is_array($seen)) $seen[] = "$file:$line";
        if (!count($trace)) break;
        
        $file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Unknown Source';
        $line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
        array_shift($trace);
    }
    
    $result = join(PHP_EOL , $result);
    if ($prev) $result .= PHP_EOL . jTraceEx($prev, $seen);
        
    return $result;
}
?>
