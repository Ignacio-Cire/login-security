<?php

// Obtiene los datos enviados
$datos = datasubmitted();

if ($datos) {
    // Extrae los datos del formulario
    $username = $datos['name'];
    $email = $datos['email'];
    $password = $datos['password'];
    $captcha = $datos['g-recaptcha-response'];

    // Verifica si el CAPTCHA está presente
    if (!$captcha) {
        echo 'Por favor, verifica el CAPTCHA.';
        exit;
    }

    // Función para validar el CAPTCHA con la API de Google
    function validar($captcha)
    {
        $secretKey = '6LfhnVkqAAAAAAYhv6_sMWmJTAwtMErZLcOiVPvV';
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
        $responseKeys = json_decode($response, true);

        return intval($responseKeys['success']) === 1;
    }

    // Valida el CAPTCHA
    if (!validar($captcha)) {
        echo 'Verificación CAPTCHA fallida. Inténtalo de nuevo.';
    } else {
        // Procede con la validación del login, como verificar en la base de datos
        echo 'Acceso concedido. Bienvenido.';
    }

// Función para obtener los datos enviados por POST o GET
    function datasubmitted()
    {
        $datos = array();
        foreach ($_POST as $key => $value) {
            $datos[$key] = $value;
        }
        foreach ($_GET as $key => $value) {
            $datos[$key] = $value;
        }
        return $datos;
    }
}
