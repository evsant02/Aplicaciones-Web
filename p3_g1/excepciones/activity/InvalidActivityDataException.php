<?php
class InvalidActivityDataException extends Exception {
    private $errors;
    
    public function __construct($errors = [], $message = "Datos de actividad no válidos", $code = 0, Throwable $previous = null) {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }
    
    public function getErrors() {
        return $this->errors;
    }
}

?>