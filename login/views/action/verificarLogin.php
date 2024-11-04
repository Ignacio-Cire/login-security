<?php
session_start();
include_once 'C:\xampp\htdocs\login-security\login\views\utils\funciones.php'; 
include_once '../../models/conector/BaseDatos.php';
include_once '../../controller/ABMusuario.php';
include_once '../../controller/session.php';

// Obtiene los datos enviados
$datos = datasubmitted();

if (!$datos) {
    echo 'No se recibieron datos. Por favor, intenta nuevamente.';
    exit;
}

if ($datos) {
    // Extrae los datos del formulario
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
        exit;
    }

    // Crear una instancia de la base de datos
    $baseDatos = new BaseDatos();

    // Crear una instancia de Usuario
    $usuario = new ABMUsuario(); 

    // Crear una instancia de Session
    $objSession = new Session();

    if ($baseDatos->Iniciar()) {
        // Llama a tu método para obtener el usuario por email
        $usuarioData = $usuario->obtenerPorEmail($baseDatos, $email);

        if ($usuarioData) {
            // Verifica la contraseña
            if (password_verify($password, $usuarioData['password'])) {
                // Inicia la sesión con el método de tu clase
                if ($objSession->iniciar($usuarioData['nombreUsuario'], $usuarioData['password'])) {
                    // Redirige a paginaSegura.php si el inicio de sesión es exitoso
                    header('Location: ../paginaSegura.php');
                    exit();
                } else {
                    echo 'Error al iniciar la sesión. Por favor, intenta nuevamente.';
                    exit();
                }
            } else {
                echo 'La contraseña es incorrecta. Inténtalo de nuevo.';
                exit();
            }
        } else {
            echo 'No existe un usuario con ese email. Por favor, verifica e intenta nuevamente.';
            exit();
        }
    } else {
        echo 'Error en la conexión a la base de datos.';
    }

    exit();
}
?>
