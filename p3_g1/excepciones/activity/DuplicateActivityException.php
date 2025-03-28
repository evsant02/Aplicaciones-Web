<?php
class DuplicateActivityException extends Exception {
    public function __construct($activityName, $code = 0, Throwable $previous = null) {
        parent::__construct("La actividad '$activityName' ya existe", $code, $previous);
    }
}

?>