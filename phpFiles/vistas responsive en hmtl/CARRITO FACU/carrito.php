<?php
session_start();
include("conexion.php");

$_SESSION['idUsuario'] = 1;
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
    }
}

// Obtener los productos en el carrito
$productosEnCarrito = obtenerCarrito();
$totalCarrito = 0;
foreach ($productosEnCarrito as $producto) {
    $totalCarrito += $producto['PrecioVenta'] * $producto['cantidad'];
}

// Obtener todos los productos disponibles
$stmt = $conexion_db->prepare("SELECT * FROM libro");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Incluir el archivo HTML
include("carrito.html");
?>
