<?php
class UserNotFoundException extends Exception {
    public function __construct($userId, $code = 0, Throwable $previous = null) {
        parent::__construct("Usuario con ID $userId no encontrado", $code, $previous);
    }
}

?>