<?php
include_once '../estructura/db.php';
include_once '../utils/funciones.php'; // Asegúrate de incluir la función datasubmitted

// Llama a la función para obtener los datos enviados
$datos = datasubmitted();

if (isset($datos['nombreUsuario'], $datos['email'], $datos['password'], $datos['g-recaptcha-response'])) {
    // Asignación de datos recibidos
    $datosUsuario = [
        'nombreUsuario' => trim($datos['nombreUsuario']),
        'email' => trim($datos['email']),
        'password' => trim($datos['password']),
        'captcha' => $datos['g-recaptcha-response']
    ];

    // Verificación de reCAPTCHA
    if (!validarCaptcha($datosUsuario['captcha'])) {
        die("Error: Verificación de reCAPTCHA fallida.");
    }

    // Validación de campos requeridos
    if (empty($datosUsuario['nombreUsuario']) || empty($datosUsuario['email']) || empty($datosUsuario['password'])) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Verificar si el usuario o el email ya existen
    $query = $conn->prepare("SELECT * FROM usuarios WHERE nombreUsuario = :nombreUsuario OR email = :email");
    $query->bindParam(':nombreUsuario', $datosUsuario['nombreUsuario']);
    $query->bindParam(':email', $datosUsuario['email']);
    $query->execute();

    if ($query->rowCount() > 0) {
        die("Error: El nombre de usuario o el email ya están registrados.");
    }

    // Encriptación de la contraseña
    $datosUsuario['password'] = password_hash($datosUsuario['password'], PASSWORD_DEFAULT);

    // Inserción del nuevo usuario en la base de datos
    $insertQuery = $conn->prepare("INSERT INTO usuarios (nombreUsuario, email, password) VALUES (:nombreUsuario, :email, :password)");
    $insertQuery->bindParam(':nombreUsuario', $datosUsuario['nombreUsuario']);
    $insertQuery->bindParam(':email', $datosUsuario['email']);
    $insertQuery->bindParam(':password', $datosUsuario['password']);

    if ($insertQuery->execute()) {
        echo "Registro exitoso. <a href='../login.php'>Inicia sesión aquí.</a>";
    } else {
        echo "Error: No se pudo completar el registro.";
    }
} else {
    echo "Error: Datos de formulario incompletos.";
}
?>
