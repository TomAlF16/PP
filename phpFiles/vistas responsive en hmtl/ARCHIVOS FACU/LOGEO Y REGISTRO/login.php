<?php
session_start();  // Iniciar sesión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'base4');  // Asegúrate de que estos datos sean correctos
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Buscar el usuario por correo electrónico
    $checkUser = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($checkUser);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si encontramos un usuario con ese correo
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificar la contraseña utilizando password_verify
        if (password_verify($password, $user['contraseña'])) {
            // Iniciar sesión con la información del usuario
            $_SESSION['user_id'] = $user['idUsuario'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['rol'] = $user['rol'];  // Asumiendo que el rol es almacenado en la base de datos

            // Redirigir al usuario a una página segura (como el perfil o inicio)
            header("Location: PAGINA PRINCIPAL copy.PHP");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
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
    <title>Biblioteca - Iniciar sesión</title>
</head>
<body>
<button onclick="history.back()" style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">Atrás</button>

    <main>
        <section>
            <div id="titulo">
                <h1>Iniciar sesión</h1>
            </div>
            <div id="inicio">
                <form action="login.php" method="POST">
                    <div id="formulario">
                        <!-- Campo para el correo electrónico -->
                        <input class="input" type="email" name="email" placeholder="Correo Electrónico" required>

                        <!-- Campo para la contraseña -->
                        <input class="input" type="password" name="password" placeholder="Contraseña" required>

                        <!-- Botón de envío -->
                        <input class="siguiente" type="submit" value="Iniciar sesión">
                    </div>
                </form>
                <div class="registrate">
                    <p>¿No tienes cuenta?</p>
                    <a href="registro.php">Regístrate aquí</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>