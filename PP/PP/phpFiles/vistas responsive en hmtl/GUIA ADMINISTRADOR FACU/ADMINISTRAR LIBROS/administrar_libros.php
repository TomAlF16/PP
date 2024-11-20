<?php
session_start();
include("conexion.php");

// Obtener las categorías de libros
$stmt = $conexion_db->prepare("SELECT * FROM categoria");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Administrar Categorias</h2>
    
    <!-- Contenedor de categorías -->
    <div class="row">
        <?php foreach ($categorias as $categoria): ?>
            <div class="col-12 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center" onclick="window.location.href='ver_libros.php?idCategoria=<?php echo $categoria['idCategoria']; ?>'">
                        <h5 class="card-title"><?php echo htmlspecialchars($categoria['nombre']); ?></h5>
                        <p class="card-text">Haz clic para ver los libros de esta categoría.</p>
                    </div>

                    <!-- Botón de eliminar con la función de confirmación -->
                    <div class="card-footer text-center">
                        <button class="btn btn-danger" onclick="window.location.href='eliminar_categoria.php?idCategoria=<?php echo $categoria['idCategoria']; ?>'">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Botón flotante para agregar un nuevo libro -->
<a href="subir categoria.php" class="btn btn-primary" style="position: fixed; bottom: 20px; right: 20px;">+ Agregar Categoria</a>

</body>
</html>
