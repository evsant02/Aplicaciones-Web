<?php

namespace includes\excepciones;

// Definición de una excepción personalizada llamada userAlreadyExistException
class UserAlreadyExistException extends \Exception
{
    // Constructor de la clase
    function __construct(string $message = "" , int $code = 0 , \Throwable $previous = null )
    {
        // Llama al constructor de la clase base Exception
        parent::__construct($message, $code, $previous);
    }
}

?>