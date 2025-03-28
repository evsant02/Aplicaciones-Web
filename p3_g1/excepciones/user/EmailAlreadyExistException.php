<?php
class EmailAlreadyExistException extends Exception {
    public function __construct($email, $code = 0, Throwable $previous = null) {
        parent::__construct("El email $email ya está registrado", $code, $previous);
    }
}

?>