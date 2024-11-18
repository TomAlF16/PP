<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirigir al login si no está logueado
    exit();
}

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'base4'); // Reemplaza con tus credenciales
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del usuario desde la base de datos
$user_id = $_SESSION['user_id']; // ID del usuario logueado
$query = "SELECT u.email, u.Numero, c.nombre, u.idUsuario
          FROM usuario u
          JOIN cliente c ON u.idUsuario = c.idUsuario
          WHERE u.idUsuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si el usuario existe
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Obtener los datos del usuario
} else {
    echo "Usuario no encontrado.";
    exit();
}

// Mensajes de éxito o error
$success_message = "";
$error_message = "";

// Verificar si el formulario ha sido enviado para actualizar los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $contraseña = $_POST['contraseña'];

    // Si la contraseña ha sido cambiada, se encripta antes de actualizar
    if (!empty($contraseña)) {
        $contraseña = password_hash($contraseña, PASSWORD_DEFAULT); // Encriptar la contraseña
        $query = "UPDATE usuario SET email = ?, contraseña = ?, Numero = ? WHERE idUsuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $email, $contraseña, $telefono, $user_id);
    } else {
        // Si la contraseña no ha sido cambiada, solo actualizamos el email, nombre y teléfono
        $query = "UPDATE usuario u 
                  JOIN cliente c ON u.idUsuario = c.idUsuario
                  SET u.email = ?, u.Numero = ?, c.nombre = ? 
                  WHERE u.idUsuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $email, $telefono, $nombre, $user_id);
    }

    // Ejecutar la actualización
    if ($stmt->execute()) {
        $success_message = "Datos actualizados con éxito.";
    } else {
        $error_message = "Error al actualizar los datos: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Editar Usuario - La Librería Confiable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header class="col">
        <nav>
            <ul style="display: flex; align-items: center;">
                <li id="title" style="flex: 1; text-align: left;">
                    <div style="width: 415px; height: 52px; background-color: #DBDBDB; color: #464646; font-size: x-large; text-align: center; margin-top: 9px; margin-left: 4%;">
                        <h1 style="margin-top: 5px;">La Librería Confiable</h1>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Título de la sección de edición de datos -->
    <div style="font-size: 1.5rem; text-align: center; margin-top: 20px; margin-bottom: 20px;">
        <strong>Editar Datos del Usuario</strong>
    </div>

    <div style="width: 50%; margin: 0 auto;">
        <!-- Mostrar mensaje de éxito o error -->
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Formulario de edición -->
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de usuario:</label>
                <input class="form-control" type="text" name="nombre" placeholder="Nombre de usuario" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico:</label>
                <input class="form-control" type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input class="form-control" type="text" name="telefono" placeholder="Teléfono" value="<?php echo htmlspecialchars($user['Numero']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <input class="form-control" type="password" name="contraseña" placeholder="Contraseña (Dejar en blanco si no deseas cambiarla)">
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col">
                    <button type="submit" class="btn btn-danger btn-block" style="width: 100%; height: 50px; font-size: large;">Guardar Cambios</button>
                </div>
                <div class="col">
                    <a href="dashboard.php" class="btn btn-secondary btn-block" style="width: 100%; height: 50px; font-size: large;">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>
