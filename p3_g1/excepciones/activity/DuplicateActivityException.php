<?php

class DuplicateActivityException extends Exception
{
    // Constructor de la clase
    function __construct(string $message = "" , int $code = 0 , Throwable $previous = null )
    {
        // Llama al constructor de la clase base Exception
        parent::__construct($message, $code, $previous);
    }
}

?>