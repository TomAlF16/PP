<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conexion.php");
include("check_session.php"); // Verificar que el usuario esté logueado

// Obtener los libros de la base de datos desde la tabla "libro"
$stmt = $conexion_db->prepare("SELECT idLibro, titulo, NombreAutor, imagen FROM libro");
$stmt->execute();
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link rel="stylesheet" href="adVerLibros.css">


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Enlace a Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

    <main class="container mt-5">
    <div class="book-container">
        <?php if (empty($libros)): ?>
            <p>No se encontraron libros disponibles.</p>
        <?php else: ?>
            <?php foreach ($libros as $libro): ?>
                <div class="book-card">
                    <img src="<?php echo htmlspecialchars($libro['imagen']); ?>" width="150" height="200" class="me-3"> 
                    <div>
                        <h2 class="fw-bold mb-1"><?php echo htmlspecialchars($libro['titulo']); ?></h2>
                        <p class="text-muted mb-0">Autor: <?php echo htmlspecialchars($libro['NombreAutor']); ?></p>
                    </div>
                    <img onclick="toggleOptions(<?php echo $libro['idLibro']; ?>)" src="png-transparent-gear.png" width="32" height="32" class="ms-auto" style="cursor: pointer;"> 
                </div>
                <!-- Contenedor de opciones, inicialmente oculto -->
                <div id="opciones-<?php echo $libro['idLibro']; ?>" class="option-box p-3 bg-secondary text-light rounded mt-2" style="display: none;">
                    <div>*Opciones adicionales para <?php echo htmlspecialchars($libro['titulo']); ?>*</div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<a href="suibir.php" class="floating-card">
    <i class="fas fa-plus"></i> <!-- Icono de más -->
</a>

    <script>
        function toggleOptions(bookId) {
            // Ocultar cualquier opción que esté visible
            document.querySelectorAll('.option-box').forEach(box => box.style.display = 'none');
            
            // Muestra el campo de opciones específico del libro seleccionado
            const opciones = document.getElementById(`opciones-${bookId}`);
            opciones.style.display = opciones.style.display === "none" ? "block" : "none";
        }
    </script>
</body>
</html>
