<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $nombreCliente = $_POST['nombreCliente']; // Nombre del cliente
    $numero = $_POST['numero'];  // Número
    $email = $_POST['email'];  // Correo electrónico
    $password = $_POST['password'];  // Contraseña

    // Encriptar la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'base4'); // Asegúrate de que estos parámetros sean correctos
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar si el correo ya está registrado
    $checkEmail = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el correo ya está registrado
        echo "El correo ya está registrado.";
    } else {
        // Si el correo no está registrado, insertamos el nuevo usuario
        $insert = "INSERT INTO usuario (email, contraseña, rol, Numero) VALUES (?, ?, 1, ?)";
        $stmt = $conn->prepare($insert);
        if ($stmt === false) {
            die("Error en la preparación de la consulta de inserción: " . $conn->error);
        }

        $stmt->bind_param("sss", $email, $passwordHash, $numero);
        if ($stmt->execute()) {
            // Obtener el ID del usuario recién insertado
            $idUsuario = $stmt->insert_id;  // Esta es la clave primaria que se generó automáticamente

            // Insertar en la tabla cliente con el idUsuario obtenido
            $insertCliente = "INSERT INTO cliente (idUsuario, nombre) VALUES (?, ?)";
            $stmt = $conn->prepare($insertCliente);
            if ($stmt === false) {
                die("Error en la preparación de la consulta de cliente: " . $conn->error);
            }

            // Usamos el nombre del cliente proporcionado en el formulario y el idUsuario
            $stmt->bind_param("is", $idUsuario, $nombreCliente);
            if ($stmt->execute()) {
                echo "Registro exitoso.";
            } else {
                echo "Error al registrar el cliente: " . $stmt->error;
            }
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Crear cuenta</title>
</head>
<body>
    <main>
        <section>
            <div id="titulo">
                <h1>Crear cuenta</h1>
            </div>
            <div id="inicio">
                <form action="registro.php" method="POST">
                    <div id="formulario">
                        <!-- Campo para el nombre del cliente -->
                        <input class="input" type="text" name="nombreCliente" placeholder="Nombre del Cliente" required>

                        <!-- Campo para el número -->
                        <input class="input" type="text" name="numero" placeholder="Número" required>

                        <!-- Campo para el correo electrónico -->
                        <input class="input" type="email" name="email" placeholder="Correo Electrónico" required>

                        <!-- Campo para la contraseña -->
                        <input class="input" type="password" name="password" placeholder="Contraseña" required>

                        <!-- Botón de envío -->
                        <input class="siguiente" type="submit" value="Registrarse">
                    </div>
                </form>
                <div class="registrate">
                    <p>¿Ya tienes una cuenta?</p>
                    <a href="login.php">Inicia sesión acá</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>