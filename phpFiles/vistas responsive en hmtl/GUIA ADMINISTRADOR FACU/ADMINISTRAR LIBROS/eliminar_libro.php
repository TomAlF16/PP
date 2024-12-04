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

// Eliminar el libro si el usuario confirma
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmtDelete = $conexion_db->prepare("DELETE FROM libro WHERE idLibro = :idLibro");
    $stmtDelete->bindParam(':idLibro', $idLibro, PDO::PARAM_INT);
    $stmtDelete->execute();

    header("Location: ver_libros.php?idCategoria=" . $libro['idCategoria']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Eliminar Libro: <?php echo htmlspecialchars($libro['titulo']); ?></h2>
    <p>¿Estás seguro de que deseas eliminar este libro?</p>

    <form method="POST" action="">
        <button type="submit" class="btn btn-danger">Eliminar</button>
        <a href="ver_libros.php?idCategoria=<?php echo $libro['idCategoria']; ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
