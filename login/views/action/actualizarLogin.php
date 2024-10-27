<?php
include_once '../controller/ABMUsuario.php'; // Incluye el controlador ABMUsuario

$abmUsuario = new ABMUsuario();

$datos = datasubmitted(); // Llama a la función para obtener los datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si el formulario fue enviado, procesa la actualización
    $datosUsuario = [
        'id' => $datos['id'],
        'nombreUsuario' => $datos['nombreUsuario'],
        'email' => $datos['email'],
        'password' => $datos['password'],
        'accion' => 'editar' // Acción de edición
    ];

    $resultado = $abmUsuario->abm($datosUsuario); // Llama al método abm para editar el usuario

    if ($resultado) {
        header('Location: ../Vista/listarUsuario.php?mensaje=actualizado'); // Redirige al listado si fue exitoso
        exit();
    } else {
        $error = "Hubo un problema al actualizar el usuario";
    }
} elseif (isset($datos['id'])) {
    // Si llega por GET, muestra el formulario con los datos del usuario actual
    $id = $datos['id'];
    $usuario = $abmUsuario->buscar(['id' => $id]);

    if (count($usuario) > 0) {
        $usuario = $usuario[0]; // Toma el primer resultado
    } else {
        echo "Usuario no encontrado";
        exit();
    }
} else {
    echo "ID de usuario no proporcionado";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Actualizar Usuario</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="actualizarLogin.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">

            <div class="form-group">
                <label for="nombreUsuario">Nombre de Usuario</label>
                <input type="text" name="nombreUsuario" class="form-control" value="<?php echo $usuario->getNombreUsuario(); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $usuario->getEmail(); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" class="form-control" value="" placeholder="Deja en blanco si no deseas cambiarla">
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="../Vista/listarUsuario.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
