<?php
session_start();
include("conexion.php");

// Obtener el ID del libro desde la URL
$idLibro = isset($_GET['idLibro']) ? (int)$_GET['idLibro'] : 0;

if ($idLibro === 0) {
    echo "Libro no válido.";
    exit;
}

// Obtener la información del libro
$stmt = $conexion_db->prepare("SELECT * FROM libro WHERE idLibro = :idLibro");
$stmt->bindParam(':idLibro', $idLibro, PDO::PARAM_INT);
$stmt->execute();
$libro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$libro) {
    echo "Libro no encontrado.";
    exit;
}

// Actualizar el libro si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $NombreAutor = $_POST['NombreAutor'];
    $PrecioVenta = $_POST['PrecioVenta'];

    $stmtUpdate = $conexion_db->prepare("UPDATE libro SET titulo = :titulo, NombreAutor = :nombreAutor, PrecioVenta = :precioVenta WHERE idLibro = :idLibro");
    $stmtUpdate->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':nombreAutor', $NombreAutor, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':precioVenta', $PrecioVenta, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':idLibro', $idLibro, PDO::PARAM_INT);
    $stmtUpdate->execute();

    header("Location: ver_libros.php?idCategoria=" . $libro['idCategoria']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Editar Libro: <?php echo htmlspecialchars($libro['titulo']); ?></h2>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="NombreAutor" class="form-label">Autor</label>
            <input type="text" id="NombreAutor" name="NombreAutor" class="form-control" value="<?php echo htmlspecialchars($libro['NombreAutor']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="PrecioVenta" class="form-label">Precio</label>
            <input type="text" id="PrecioVenta" name="PrecioVenta" class="form-control" value="<?php echo htmlspecialchars($libro['PrecioVenta']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>

</body>
</html>
