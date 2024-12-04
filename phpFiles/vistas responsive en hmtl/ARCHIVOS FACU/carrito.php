<?php
// Iniciar la sesión y establecer la conexión a la base de datos
session_start();
include("conexion.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['idUsuario'])) {
    echo "Por favor, inicie sesión.";
    exit;
}

$idUsuario = $_SESSION['idUsuario'];

// Obtener el idCliente del usuario logueado
$stmt = $conexion_db->prepare("SELECT idCliente FROM cliente WHERE idUsuario = ?");
$stmt->execute([$idUsuario]);
$idCliente = $stmt->fetchColumn();

// Función para agregar un producto al carrito
function agregarProductoAlCarrito($idCliente, $idLibro, $cantidad) {
    global $conexion_db;
    
    // Verificar si el producto ya está en el carrito del cliente
    $stmt = $conexion_db->prepare("SELECT idCarrito FROM carrito WHERE idCliente = ? AND idLibro = ?");
    $stmt->execute([$idCliente, $idLibro]);
    $existe = $stmt->fetchColumn();

    if ($existe) {
        // Si el producto ya está en el carrito, actualizar la cantidad
        $stmt = $conexion_db->prepare("UPDATE carrito SET cantidad = ? WHERE idCliente = ? AND idLibro = ?");
        $stmt->execute([$cantidad, $idCliente, $idLibro]);
    } else {
        // Si el producto no está en el carrito, agregarlo
        $stmt = $conexion_db->prepare("INSERT INTO carrito (idCliente, idLibro, cantidad) VALUES (?, ?, ?)");
        $stmt->execute([$idCliente, $idLibro, $cantidad]);
    }
}

// Función para eliminar un producto del carrito
function eliminarProductoDelCarrito($idCarrito) {
    global $conexion_db;
    $stmt = $conexion_db->prepare("DELETE FROM carrito WHERE idCarrito = ?");
    $stmt->execute([$idCarrito]);
}

// Procesar la acción de agregar al carrito
if (isset($_GET['action']) && $_GET['action'] == 'agregar' && isset($_GET['producto_id']) && isset($_GET['cantidad'])) {
    $idLibro = (int)$_GET['producto_id'];
    $cantidad = (int)$_GET['cantidad'];

    // Verificar que la cantidad sea válida y que haya stock disponible
    $stmt = $conexion_db->prepare("SELECT stockVenta FROM libro WHERE idLibro = ?");
    $stmt->execute([$idLibro]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto && $producto['stockVenta'] >= $cantidad) {
        // Agregar el producto al carrito
        agregarProductoAlCarrito($idCliente, $idLibro, $cantidad);
        // Redirigir al carrito para mostrar la actualización
        header("Location: carrito.php");
        exit;
    } else {
        // Si no hay suficiente stock, mostrar un mensaje
        echo "No hay suficiente stock disponible.";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'actualizar' && isset($_GET['idCarrito']) && isset($_GET['cantidad'])) {
    $idCarrito = (int)$_GET['idCarrito'];
    $cantidad = (int)$_GET['cantidad'];

    // Verificar que la cantidad sea válida y que haya stock disponible
    $stmt = $conexion_db->prepare("SELECT * FROM libro WHERE titulo = '" . str_replace("+" , " " , $_GET['titulo']   ) ."'" );
    $stmt->execute( [1] );
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto && $producto['stockVenta'] >= $cantidad) {
        // Agregar el producto al carrito
        agregarProductoAlCarrito($idCliente, $producto['idLibro'], $cantidad);
        // Redirigir al carrito para mostrar la actualización
        header("Location: carrito.php");
        exit;
    } else {
        // Si no hay suficiente stock, mostrar un mensaje
        echo "No hay suficiente stock disponible.";
    }
}


// Procesar la acción de eliminar del carrito
if (isset($_GET['action']) && $_GET['action'] == 'eliminar' && isset($_GET['idCarrito'])) {
    $idCarrito = (int)$_GET['idCarrito'];
    eliminarProductoDelCarrito($idCarrito);
    header("Location: carrito.php");
    exit;
}

// Función para obtener el stock disponible de un producto
function obtenerStockDisponible($idLibro) {
    global $conexion_db;
    $stmt = $conexion_db->prepare("SELECT stockVenta FROM libro WHERE idLibro = ?");
    $stmt->execute([$idLibro]);
    return $stmt->fetchColumn();
}

// Función para obtener los productos en el carrito
function obtenerCarrito($idCliente) {
    global $conexion_db;
    $stmt = $conexion_db->prepare("SELECT c.idCarrito, l.titulo, c.cantidad, l.PrecioVenta, l.idLibro
                                   FROM carrito c
                                   JOIN libro l ON c.idLibro = l.idLibro
                                   WHERE c.idCliente = ?");
    $stmt->execute([$idCliente]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener los productos disponibles
function obtenerProductosDisponibles() {
    global $conexion_db;
    $stmt = $conexion_db->prepare("SELECT * FROM libro ORDER BY RAND() LIMIT 5");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener los productos del carrito
$productosEnCarrito = obtenerCarrito($idCliente);
$totalCarrito = 0;
foreach ($productosEnCarrito as $producto) {
    $totalCarrito += $producto['PrecioVenta'] * $producto['cantidad'];
}

// Obtener todos los productos disponibles
$productosDisponibles = obtenerProductosDisponibles();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="carrito.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
    <header class="bg-bordo py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-light m-0">La Librería Confiable</h1>
            <div class="search-area d-flex align-items-center">
                <button class="btn btn-light">
                    <img src="https://images.emojiterra.com/google/noto-emoji/unicode-15.1/color/svg/1f6d2.svg" width="25" height="25">
                </button>
            </div>
        </div>
    </header>

    <main class="container mt-5">
        <div class="cart-section d-flex">
            <div class="cart-items flex-grow-1 p-3 bg-light rounded shadow">
                <h2>Tu carrito:</h2>
                <?php if (empty($productosEnCarrito)): ?>
                    <p>El carrito está vacío.</p>
                <?php else: ?>
                    <?php foreach ($productosEnCarrito as $producto): 
                        // Obtener el stock disponible
                        $stockDisponible = obtenerStockDisponible($producto['idLibro']);
                    ?>
                        <div class="cart-item d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded shadow-sm">
                            <div class="d-flex align-items-center">
                                <p class="mb-1 fw-bold"><?php echo htmlspecialchars($producto['titulo']); ?></p>
                                <p class="ms-3 mb-1">AR$ <?php echo number_format($producto['PrecioVenta'], 0, ',', '.'); ?></p>
                                <p class="ms-3 mb-1">Cantidad: <?php echo $producto['cantidad']; ?></p>
                            </div>
                            <!-- Formulario para seleccionar la cantidad con <select> -->
                            <form action="carrito.php" method="GET" class="d-flex align-items-center">
                                <select name="cantidad" class="form-control w-auto">
                                    <?php for ($i = 1; $i <= $stockDisponible; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo ($producto['cantidad'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <input type="hidden" name="idCarrito" value="<?php echo $producto['idCarrito']; ?>">
                                <input type="hidden" name="titulo" value="<?php echo $producto['titulo']; ?>">
                                <input type="hidden" name="action" value="actualizar">
                                <button type="submit" class="btn btn-success btn-sm ms-2">Actualizar</button>
                            </form>
                            <!-- Botón para eliminar producto -->
                            <a href="carrito.php?action=eliminar&idCarrito=<?php echo $producto['idCarrito']; ?>" class="btn btn-danger btn-sm ms-2">Eliminar</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="cart-summary ms-3 p-3 bg-light rounded shadow">
                <h3>AR$ <?php echo number_format($totalCarrito, 0, ',', '.'); ?></h3>
                <button class="btn btn-primary w-100 mt-3">COMPRAR AHORA</button>
            </div>
        </div>

        <h2 class="mt-5">Productos disponibles</h2>
        <div class="product-list d-flex flex-wrap">
            <?php foreach ($productosDisponibles as $producto): ?>
                <div class="product-card text-center p-3 m-2">
                    <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto" class="img-fluid mb-2" style="max-height: 150px;">
                    <p><?php echo htmlspecialchars($producto['titulo']); ?></p>
                    <p>AR$ <?php echo number_format($producto['PrecioVenta'], 0, ',', '.'); ?></p>
                    <p class="book-author"><strong>Autor:</strong> <?= htmlspecialchars($producto['NombreAutor']) ?></p>
                    <a class="btn btn-danger text-light" href="producto.php?idLibro=<?php echo $producto['idLibro']; ?>">Ver más</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
