<?php
// Activar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
include("conexion.php");

// Iniciar o restaurar la sesión
session_start();

// Verificar si el usuario ya está logueado
if (!isset($_SESSION['login_user'])) {
    // Si no está logueado, obtener el primer usuario de la tabla
    $stmt = $conexion_db->prepare("SELECT idCliente, nombre FROM cliente LIMIT 1");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $_SESSION['login_user'] = $row['nombre']; // Almacenar el usuario en la sesión
    } else {
        // Si no hay usuarios en la tabla, mostrar un mensaje de error
        die("No se encontraron usuarios en la tabla de clientes.");
    }
}

// Preparar la consulta SQL para obtener todos los clientes
$stmt = $conexion_db->prepare("SELECT idCliente, nombre FROM cliente");
$stmt->execute();

// Obtener todos los resultados de la consulta
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
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
                    <h1 style="margin-top: 5px;">La Librería Confiable</h1>
                </div>
                </li>
                <div class="col" style="flex: 2; margin-left: -40%;">
                    <div class="search-bar">
                        <input type="text" placeholder="Buscar..." style="margin-left: -30%; width: 555px; height: 47px;">
                        <button style="background-color: #464646; width:40px; height:40px">🤍</button>
                        <button style="width:159px; height: 51px; background-color: #D7D5D5;">
                            <img src="https://images.emojiterra.com/google/noto-emoji/unicode-15.1/color/svg/1f6d2.svg" width="25" height="25" style="margin-left: 80%;">
                        </button>
                    </div>
                </div>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-sm"></div>
            <div class="col-sm" style="margin-top: 5%">
                <?php foreach ($clientes as $cliente): ?>
                    <div id="espacioDelUsuario">
                        <img src="1077114.png" width="64" height="64" style="margin-top: 1.5%;"> 
                        <div style="margin-top: -4%; margin-left: 8%;">
                            <p>Nombre del cliente: <?php echo htmlspecialchars($cliente['nombre']); ?></p>
                        </div>
                        <img onclick="mostrar()" src="png-transparent-gear.png" width="64" height="64" style="margin-top: -3%; margin-left: 90%;"> 
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-sm">
                <div id="espacioDelUsuario2" style="display:none">
                    <div style="margin-left:20%;">*opcion sin definir*</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrar(){
            const espaciodiv = document.getElementById("espacioDelUsuario2");
            espaciodiv.style.display = espaciodiv.style.display === "none" || espaciodiv.style.display === "" ? "block" : "none";
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
