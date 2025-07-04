<?php
namespace includes\donar;

use includes\application;

class pagoRedsys {

    public static function procesar($cantidad) {
        $app = application::getInstance();
        $app->putAtributoPeticion('donacion_cantidad', $cantidad);

        //Datos no constantes para Redsys
        $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname($_SERVER['SCRIPT_NAME']);
        $urlOK = "$protocolo://$host$path/OK.php";
        $urlKO = "$protocolo://$host$path/KO.php";
        $order = str_pad(date('mdHis'), 12, "0", STR_PAD_LEFT);

        // Parámetros Redsys
        $params = [
            'DS_MERCHANT_AMOUNT' => strval(intval($cantidad * 100)),
            'DS_MERCHANT_ORDER' => $order,
            'DS_MERCHANT_MERCHANTCODE' => CODIGOCOMERCIO,
            'DS_MERCHANT_CURRENCY' => MONEDA,
            'DS_MERCHANT_TRANSACTIONTYPE' => TRANSACTION,
            'DS_MERCHANT_TERMINAL' => TERMINAL,
            'DS_MERCHANT_URLOK' => $urlOK,
            'DS_MERCHANT_URLKO' => $urlKO,
            'DS_MERCHANT_MERCHANTURL' => $urlOK,
        ];

        $json = json_encode($params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $base64Params = base64_encode($json);

        $signature = self::generateKey(CLAVE, $order, $base64Params);

        $url = URL;

        $form = <<<HTML
            <form id="pagoRedsys" action=$url method="POST">
                <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1">
                <input type="hidden" name="Ds_MerchantParameters" value="$base64Params">
                <input type="hidden" name="Ds_Signature" value="$signature">
                <p>Redirigiendo a Redsys...</p>
            </form>
            <script>document.getElementById('pagoRedsys').submit();</script>
        HTML;

        return $form;
    }

    // Firma
    private static function encrypt_3DES($message, $key) {
        $key = base64_decode($key);
        $iv = "\x00\x00\x00\x00\x00\x00\x00\x00";
        $l = ceil(strlen($message) / 8) * 8;
        $messagePadded = str_pad($message, $l, "\0");
        return openssl_encrypt($messagePadded, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
    }

    private static function generateKey($clave, $order, $params) {
        $claveDerivada = self::encrypt_3DES($order, $clave);
        $hash = hash_hmac('sha256', $params, $claveDerivada, true);
        return base64_encode($hash);
    }
}
?>