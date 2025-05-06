<?php
namespace includes\donar;

use includes\comun\formBase;

class donarForm extends formBase {
    public function __construct() {
        parent::__construct('donarForm');
    }

    protected function CreateFields($datos) {
        $cantidad = $datos['cantidad'] ?? '';

        $html = <<<EOF
        <div class="inForm">
            <fieldset>
                <p>Al pulsar "Donar" serás redirigido a una pasarela de pago externa (REDSYS) para completar tu donación.</p>
                <p>*Esta operación será completamente anónima.</p>
                <p><label>Cantidad:</label><input type="number" name="cantidad" value="$cantidad" step="0.01" max="9999.99" min="1" required /> (€)</p>
                <button type="submit">Donar</button>
            </fieldset>
        </div>
        EOF;

        return $html;
    }

    protected function Process($datos) {
        if (!isset($datos['cantidad']) || !is_numeric($datos['cantidad']) || $datos['cantidad'] < 1) {
            return ["Introduce una cantidad válida (1 y 9999.99€)."];
        }

        $cantidad = floatval($datos['cantidad']);
        // Redirigir a la segunda vista
        echo pagoRedsys::procesar($cantidad);
        exit;
    }
}