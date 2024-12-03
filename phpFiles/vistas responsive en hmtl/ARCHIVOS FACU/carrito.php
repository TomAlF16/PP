<?php
session_start();
include("conexion.php");

$_SESSION['idUsuario'] = 1;  // Asignar el ID del usuario logueado
$idUsuario = $_SESSION['idUsuario'];

// Obtener el idCliente del usuario logueado
$stmt = $conexion_db->prepare("SELECT idCliente FROM cliente WHERE idUsuario = ?");
$stmt->execute([$idUsuario]);
$idCliente = $stmt->fetchColumn();

// Función para agregar un producto al carrito
function agregarAlCarrito($idLibro, $cantidad) {
    global $conexion_db, $idCliente;

    $stmt = $conexion_db->prepare("SELECT idCarrito FROM carrito WHERE idCliente = ? AND idLibro = ?");
    $stmt->execute([$idCliente, $idLibro]);
    $carrito = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($carrito) {
        $idCarrito = $carrito['idCarrito'];
        $stmt = $conexion_db->prepare("UPDATE carrito SET cantidad = cantidad + ? WHERE idCarrito = ?");
        $stmt->execute([$cantidad, $idCarrito]);
    } else {
        $stmt = $conexion_db->prepare("INSERT INTO carrito (idCliente, idLibro, cantidad) VALUES (?, ?, ?)");
        $stmt->execute([$idCliente, $idLibro, $cantidad]);
    }
}

// Función para eliminar un producto del carrito
function eliminarDelCarrito($idCarrito) {
    global $conexion_db;
    $stmt = $conexion_db->prepare("DELETE FROM carrito WHERE idCarrito = ?");
    $stmt->execute([$idCarrito]);
}

// Función para actualizar la cantidad de un producto en el carrito
function actualizarCantidad($idCarrito, $nuevaCantidad) {
    global $conexion_db;
    $stmt = $conexion_db->prepare("UPDATE carrito SET cantidad = ? WHERE idCarrito = ?");
    $stmt->execute([$nuevaCantidad, $idCarrito]);
}

// Función para obtener los productos en el carrito
function obtenerCarrito() {
    global $conexion_db, $idCliente;

    $stmt = $conexion_db->prepare("SELECT c.idCarrito, l.titulo, c.cantidad, l.PrecioVenta 
                                   FROM carrito c
                                   JOIN libro l ON c.idLibro = l.idLibro
                                   WHERE c.idCliente = ?");
    $stmt->execute([$idCliente]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para realizar la compra
function realizarCompra() {
    global $conexion_db, $idCliente;

    // Obtener los productos del carrito
    $productosEnCarrito = obtenerCarrito();
    if (count($productosEnCarrito) > 0) {
        // Calcular el total
        $total = 0;
        foreach ($productosEnCarrito as $producto) {
            $total += $producto['PrecioVenta'] * $producto['cantidad'];
        }

        // Registrar la compra
        $stmt = $conexion_db->prepare("INSERT INTO compra (idCliente, total) VALUES (?, ?)");
        $stmt->execute([$idCliente, $total]);

        // Obtener el ID de la compra registrada
        $idCompra = $conexion_db->lastInsertId();

        // Asociar los productos comprados con la compra
        foreach ($productosEnCarrito as $producto) {
            $stmt = $conexion_db->prepare("INSERT INTO detalle_compra (idCompra, idLibro, cantidad, precio) 
                                           VALUES (?, ?, ?, ?)");
            $stmt->execute([$idCompra, $producto['idLibro'], $producto['cantidad'], $producto['PrecioVenta']]);
        }

        // Eliminar los productos del carrito después de la compra
        $stmt = $conexion_db->prepare("DELETE FROM carrito WHERE idCliente = ?");
        $stmt->execute([$idCliente]);

        return true;  // Compra exitosa
    } else {
        return false;  // Carrito vacío
    }
}

// Procesar acciones del carrito
if (isset($_GET['action'])) {
    $idLibro = (int)$_GET['producto_id'];
    if ($_GET['action'] == 'agregar' && isset($_GET['cantidad'])) {
        agregarAlCarrito($idLibro, (int)$_GET['cantidad']);
    } elseif ($_GET['action'] == 'eliminar') {
        $idCarrito = (int)$_GET['idCarrito'];
        eliminarDelCarrito($idCarrito);
    } elseif ($_GET['action'] == 'actualizar' && isset($_GET['cantidad']) && isset($_GET['idCarrito'])) {
        // Actualizar la cantidad del producto en el carrito
        actualizarCantidad((int)$_GET['idCarrito'], (int)$_GET['cantidad']);
    } elseif ($_GET['action'] == 'comprar') {
        // Realizar la compra
        if (realizarCompra()) {
            header("Location: confirmacion.php");  // Redirigir a una página de confirmación de compra
            exit();
        } else {
            echo "No hay productos en el carrito.";
        }
    }
}

// Obtener los productos en el carrito
$productosEnCarrito = obtenerCarrito();
$totalCarrito = 0;
foreach ($productosEnCarrito as $producto) {
    $totalCarrito += $producto['PrecioVenta'] * $producto['cantidad'];
}

// Obtener todos los productos disponibles
$stmt = $conexion_db->prepare("SELECT * FROM libro ORDER BY RAND() LIMIT 5 ");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Incluir el archivo HTML
include("carrito.html");
?>
