<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conexion.php");
session_start();

if (!isset($_SESSION['login_user'])) {
    $stmt = $conexion_db->prepare("
        SELECT cliente.idCliente, cliente.nombre, usuario.email 
        FROM cliente 
        INNER JOIN usuario ON cliente.idUsuario = usuario.idUsuario 
        LIMIT 1
    ");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $_SESSION['login_user'] = $row['nombre'];
    } else {
        die("No se encontraron usuarios en la tabla de clientes.");
    }
}

$stmt = $conexion_db->prepare("
    SELECT cliente.idCliente, cliente.nombre, usuario.email 
    FROM cliente 
    INNER JOIN usuario ON cliente.idUsuario = usuario.idUsuario
");
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>La Librería Confiable</title>
</head>

<body>
    <!-- Header con color bordó y mejor estructura -->
    <header class="bg-bordo py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-light m-0">La Librería Confiable</h1>
            <div class="search-area d-flex align-items-center">
                <input type="text" class="form-control" placeholder="Buscar...">
                <button class="btn btn-secondary mx-2">🔍</button>
                <button class="btn btn-light">
                    <img src="https://images.emojiterra.com/google/noto-emoji/unicode-15.1/color/svg/1f6d2.svg" width="25" height="25">
                </button>
            </div>
        </div>
    </header>

    <main class="container mt-5 d-flex flex-column align-items-center">
        <?php foreach ($clientes as $cliente): ?>
            <div class="user-space w-100 d-flex align-items-center bg-light p-3 rounded mb-3 shadow-sm" id="user-<?php echo $cliente['idCliente']; ?>">
                <img src="1077114.png" width="64" height="64" class="rounded-circle me-3"> 
                <div>
                    <p class="fw-bold mb-0">Nombre del cliente: <?php echo htmlspecialchars($cliente['nombre']); ?></p>
                    <p class="text-muted mb-0">Email: <?php echo htmlspecialchars($cliente['email']); ?></p>
                </div>
                <img onclick="toggleOptions(<?php echo $cliente['idCliente']; ?>)" src="png-transparent-gear.png" width="32" height="32" class="ms-auto" style="cursor: pointer;"> 
            </div>
            <!-- Contenedor de opciones, inicialmente oculto -->
            <div id="opciones-<?php echo $cliente['idCliente']; ?>" class="option-box p-3 bg-secondary text-light rounded mt-2" style="display: none;">
                <div>*Opciones adicionales para <?php echo htmlspecialchars($cliente['nombre']); ?>*</div>
            </div>
        <?php endforeach; ?>
    </main>

    <script>
        function toggleOptions(userId) {
            // Oculta cualquier opción que esté visible
            document.querySelectorAll('.option-box').forEach(box => box.style.display = 'none');
            
            // Muestra el campo de opciones específico del usuario seleccionado
            const opciones = document.getElementById(`opciones-${userId}`);
            opciones.style.display = opciones.style.display === "none" ? "block" : "none";
        }
    </script>
</body>
</html>

<style>
    