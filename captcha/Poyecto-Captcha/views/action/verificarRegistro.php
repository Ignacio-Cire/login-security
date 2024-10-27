<?php

require_once '../utils/funciones'; // Importa la función datasubmitted 



// Obtiene los datos enviados
$datos = datasubmitted();

if (!$datos) {
    echo 'No se recibieron datos. Por favor, intenta nuevamente.';
    exit;
}

if ($datos) {
    // Extrae los datos del formulario
    $username = $datos['nombreUsuario'];
    $email = $datos['email'];
    $password = $datos['password'];
    $captcha = $datos['g-recaptcha-response'];

    // Verifica si el CAPTCHA está presente
    if (!$captcha) {
        echo 'Por favor, verifica el CAPTCHA.';
        exit;
    }

  
    
    // Valida el CAPTCHA
    if (!validarCaptcha($captcha)) {
        echo 'Verificación CAPTCHA fallida. Inténtalo de nuevo.';
    } else {
        // Procede con la validación del registro, como verificar en la base de datos
        echo 'Acceso concedido. Bienvenido.';
    }



    
}   
