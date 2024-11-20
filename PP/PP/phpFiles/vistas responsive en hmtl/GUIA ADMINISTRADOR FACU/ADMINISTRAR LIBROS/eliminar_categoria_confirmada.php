<?php
session_start();
include("conexion.php");

// Verificar si se recibió el ID de la categoría desde el formulario
if (isset($_POST['idCategoria'])) {
    $idCategoria = $_POST['idCategoria'];

    try {
        // Iniciar la transacción para garantizar la integridad de los datos
        $conexion_db->beginTransaction();

        // Eliminar los registros del carrito asociados a los libros de esta categoría
        $stmt = $conexion_db->prepare("DELETE FROM carrito WHERE idLibro IN (SELECT idLibro FROM libro WHERE idCategoria = :idCategoria)");
        $stmt->bindParam(':idCategoria', $idCategoria);
        $stmt->execute();

        // Eliminar los libros asociados a la categoría
        $stmt = $conexion_db->prepare("DELETE FROM libro WHERE idCategoria = :idCategoria");
        $stmt->bindParam(':idCategoria', $idCategoria);
        $stmt->execute();

        // Luego, eliminar la categoría
        $stmt = $conexion_db->prepare("DELETE FROM categoria WHERE idCategoria = :idCategoria");
        $stmt->bindParam(':idCategoria', $idCategoria);
        $stmt->execute();

        // Confirmar la transacción
        $conexion_db->commit();

        // Redirigir al administrador de libros después de eliminar
        header("Location: administrar_libros.php");
        exit();
    } catch (PDOException $e) {
        // Si ocurre un error, revertir la transacción
        $conexion_db->rollBack();
        echo "Error al eliminar la categoría: " . $e->getMessage();
    }
} else {
    echo "No se especificó una categoría para eliminar.";
    exit();
}
