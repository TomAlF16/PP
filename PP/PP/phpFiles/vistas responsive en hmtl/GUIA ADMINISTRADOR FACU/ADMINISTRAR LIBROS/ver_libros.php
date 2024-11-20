<?php
session_start();
include("conexion.php");

// Obtener el ID de la categoría seleccionada
if (isset($_GET['idCategoria'])) {
    $idCategoria = $_GET['idCategoria'];

    // Obtener los libros asociados a esta categoría
    $stmt = $conexion_db->prepare("SELECT * FROM libro WHERE idCategoria = :idCategoria");
    $stmt->bindParam(':idCategoria', $idCategoria);
    $stmt->execute();
    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener el nombre de la categoría para mostrarlo
    $stmt_categoria = $conexion_db->prepare("SELECT nombre FROM categoria WHERE idCategoria = :idCategoria");
    $stmt_categoria->bindParam(':idCategoria', $idCategoria);
    $stmt_categoria->execute();
    $categoria = $stmt_categoria->fetch(PDO::FETCH_ASSOC);
} else {
    echo "No se ha seleccionado una categoría.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros en la categoría <?php echo htmlspecialchars($categoria['nombre']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Libros en la categoría: <?php echo htmlspecialchars($categoria['nombre']); ?></h2>
    
    <!-- Contenedor de libros -->
    <div class="row">
        <?php foreach ($libros as $libro): ?>
            <div class="col-12 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($libro['titulo']); ?></h5>
                        <p class="card-text">Autor: <?php echo htmlspecialchars($libro['NombreAutor']); ?></p>
                        <p class="card-text">Precio: $<?php echo htmlspecialchars($libro['PrecioVenta']); ?></p>
                    </div>

                    <!-- Botón de eliminar con la función de confirmación -->
                    <div class="card-footer text-center">
                        <a href="eliminar_libro.php?idLibro=<?php echo $libro['idLibro']; ?>" class="btn btn-danger">
                            Eliminar
                        </a>
                        <a href="editar_libro.php?idLibro=<?php echo $libro['idLibro']; ?>" class="btn btn-warning">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Botón flotante para agregar un nuevo libro -->
    <a href="suibir.php" class="btn btn-primary" style="position: fixed; bottom: 20px; right: 20px;">+ Agregar Libro</a>
</div>

</body>
</html>
