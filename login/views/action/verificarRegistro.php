<?php
session_start();
include_once 'C:\xampp\htdocs\login-security\login\views\utils\funciones.php'; 
include_once '../../models/conector/BaseDatos.php';
include_once '../../models/Usuario.php';

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
        exit; // Asegúrate de salir si falla la validación
    }

    // Crear una instancia de la base de datos
    $baseDatos = new BaseDatos();

    // Crear una instancia de Usuario
    $usuario = new Usuario($username, $email, password_hash($password, PASSWORD_BCRYPT)); // usar hash para la contraseña

    if ($baseDatos->Iniciar()) {
        // Llama a tu método para insertar el usuario
        if ($usuario->insertar($baseDatos)) { // Asegúrate de tener un método insertar en tu clase Usuario
            // Mensaje de éxito guardado en la sesión
            $_SESSION['mensaje'] = 'Registro exitoso. Puedes iniciar sesión ahora.';
            // Redirige a login.php después de un registro exitoso
            header('Location: ../login.php');
            exit();
        } else {
            echo 'Error al registrar el usuario. Intenta de nuevo.'; // Mensaje de error
        }
    } else {
        echo 'Error en la conexión a la base de datos.'; // Mensaje de error
    }

    exit();
}
