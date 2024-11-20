<?php
session_start();
include("conexion.php");

// Verificar si se recibió un parámetro 'idCategoria' por GET
if (isset($_GET['idCategoria'])) {
    $idCategoria = $_GET['idCategoria'];

    // Obtener información de la categoría
    $stmt = $conexion_db->prepare("SELECT * FROM categoria WHERE idCategoria = :idCategoria");
    $stmt->bindParam(':idCategoria', $idCategoria);
    $stmt->execute();
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$categoria) {
        echo "Categoría no encontrada.";
        exit();
    }
} else {
    echo "No se especificó una categoría para eliminar.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2>¿Estás seguro de que deseas eliminar la categoría "<?php echo htmlspecialchars($categoria['nombre']); ?>"?</h2>
    <p>Al eliminar esta categoría, se eliminarán todos los libros y los registros asociados.</p>

    <!-- Formulario que envía el ID de la categoría -->
    <form method="POST" action="eliminar_categoria_confirmada.php">
        <input type="hidden" name="idCategoria" value="<?php echo $idCategoria; ?>" />
        <button type="submit" class="btn btn-danger">Eliminar Categoría</button>
        <a href="administrar_libros.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
