<?php
class InvalidCredentialsException extends Exception {
    public function __construct($message = "Credenciales inválidas", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
?>