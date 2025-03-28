<?php
class ActivityNotFoundException extends Exception {
    public function __construct($activityId, $code = 0, Throwable $previous = null) {
        parent::__construct("Actividad con ID $activityId no encontrada", $code, $previous);
    }
}

?>