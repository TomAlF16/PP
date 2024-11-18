<?php
session_start();  // Asegúrate de que la sesión esté activa

// Verifica que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    echo "Usuario no autenticado.";
    exit;
}

$idUsuario = $_SESSION['user_id'];  // Obtén el idUsuario desde la sesión

// Conexión a la base de datos
try {
    // Aquí debes configurar tu conexión a la base de datos con los datos correctos
    $pdo = new PDO("mysql:host=localhost;dbname=base4", "root", "");  // Cambia estos datos según tu configuración
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta SQL para obtener los datos del usuario y cliente
    $sql = "SELECT u.email, u.Numero, c.idCliente, c.nombre
            FROM usuario u
            JOIN cliente c ON u.idUsuario = c.idUsuario
            WHERE u.idUsuario = :idUsuario";
    
    // Preparar la consulta y ejecutarla
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    
    // Recuperar los resultados
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verifica si se obtuvieron resultados
    if ($usuario) {
        $nombre = $usuario['nombre'];
        $email = $usuario['email'];
        $telefono = $usuario['Numero'];
        
    } else {
        $nombre = "No disponible";
        $email = "No disponible";
        $telefono = "No disponible";
       
    }
    
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo "Error en la conexión: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>La Libreria Confiable</title>
</head>
<body>
    <header class="col">
        <nav>
            <ul style="display: flex; align-items: center;">
                <li id="title" style="flex: 1; text-align: left;">
                    <div style="width: 415px;
                    height: 52px;
                    background-color: #DBDBDB; color: #464646; font-size: x-large; text-align: center; margin-top: 9px; margin-left: 4%;">
                        <h1 style="margin-top: 5px;" >La Librería Confiable</h1>
                    </div>
                </li>

                <div class="col" style="flex: 2; margin-left: -40%;">
                    <div class="search-bar">
                        <input type="text" placeholder="Buscar..." style="margin-left: -30%; width: 555px; height: 47px;">
                        <button style="background-color: #464646; width:40px; height:40px">🤍</button>
                        <button style="width:159px; height: 51px; background-color: #D7D5D5;">
                            <img src="https://images.emojiterra.com/google/noto-emoji/unicode-15.1/color/svg/1f6d2.svg" width="25" height="25" style="margin-left: 80%;" />
                        </button>
                    </div>
                </div>
            </ul>
        </nav>
    </header>

    <div class="container text-center">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div style="margin-top:5%">
                    <div id="ParteGris">
                        <h3>Detalles de la cuenta</h3>
                        <div id="ParteBlanca">
                            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                            
                            
                        </div>
                        
                        <button type="button" id="CerrarSesion">Cerrar sesión</button>
                    </div>
                </div>

                <div style="margin-top:5%">
                    <div id="ParteGris">
                        <h3>Información general</h3>
                        <div id="ParteBlanca">
                            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono); ?></p>
                            <p><strong>Método de pago:</strong> No disponible</p>
                        </div>
                    </div>
                    <button type="button" id="CerrarSesion">Editar</button>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
