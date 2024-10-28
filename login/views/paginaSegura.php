<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si no está autenticado, redirige al login
    header('Location: ../view/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Segura</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido/a !!</h1>
        <p> <?php echo htmlspecialchars($_SESSION['usuario']); ?>. Has iniciado sesión exitosamente.</p>
        
        <!-- Puedes agregar contenido adicional aquí -->

        <!-- Botón para cerrar sesión -->
        <form action="logout.php" method="POST">
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
