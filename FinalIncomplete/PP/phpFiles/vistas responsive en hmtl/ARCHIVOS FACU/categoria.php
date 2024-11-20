<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base4";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID de la categoría desde la URL
$idCategoria = isset($_GET['idCategoria']) ? intval($_GET['idCategoria']) : 0;

// Consultar los libros de la categoría seleccionada
$sql = "SELECT * FROM libro WHERE idCategoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCategoria);
$stmt->execute();
$result = $stmt->get_result();

// Obtener el nombre de la categoría
$sqlCategoria = "SELECT nombre FROM categoria WHERE idCategoria = ?";
$stmtCategoria = $conn->prepare($sqlCategoria);
$stmtCategoria->bind_param("i", $idCategoria);
$stmtCategoria->execute();
$resultCategoria = $stmtCategoria->get_result();
$categoria = $resultCategoria->fetch_assoc();

// Si no se encuentra la categoría, redirigir o mostrar error
if (!$categoria) {
    die("Categoría no encontrada.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros de <?= htmlspecialchars($categoria['nombre']) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Barra de navegación -->
    <header class="navbar">
        <div class="logo">
            <span>📚 La Librería Confiable</span>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Buscar libros...">
            <button>🔍</button>
        </div>
        <div class="cart">
            <a href="carrito.php">
                <button>🛒 Carrito</button>
            </a>
        </div>
    </header>

    <!-- Libros de la categoría -->
    <main class="main-content">
        <section class="recommended-books">
            <h2>Libros de <?= htmlspecialchars($categoria['nombre']) ?></h2>
            <div class="product-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                       <div class="product-card">
    <img src="<?= htmlspecialchars($row['imagen']) ?>" alt="Imagen del libro">
    <h3><?= htmlspecialchars($row['titulo']) ?></h3>
    <p><strong>Autor:</strong> <?= htmlspecialchars($row['NombreAutor']) ?></p>
    <p><strong>Precio:</strong> $<?= number_format($row['PrecioVenta'], 2) ?></p>
    <!-- Botón Ver más -->
    <a href="producto.php?idLibro=<?= $row['idLibro'] ?>">Ver más</a>
</div>
                        
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No hay libros disponibles en esta categoría.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php 
    // Cerrar conexión
    $stmt->close();
    $stmtCategoria->close();
    $conn->close();
    ?>
</body>
</html>

<style>
    /* Estilos generales */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    color: #333;
}

/* Barra de navegación */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 30px;
    background-color: #a14949;
    color: white;
}

.navbar .logo span {
    font-size: 24px;
    font-weight: bold;
}

.navbar .search-bar input {
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.navbar .search-bar button {
    padding: 8px 15px;
    background-color: #1ABC9C;
    border: none;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.navbar .cart button {
    background-color: #E74C3C;
    border: none;
    padding: 8px 15px;
    color: white;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

/* Contenido principal */
.main-content {
    padding: 30px 20px;
    text-align: center;
}

.recommended-books h2 {
    font-size: 28px;
    color: #2C3E50;
    margin-bottom: 20px;
}

/* Estilos para las tarjetas de productos */
.product-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

.product-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 220px;
    padding: 15px;
    text-align: center;
    transition: transform 0.2s ease;
}

.product-card:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.product-card img {
    width: 100%;
    max-height: 150px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
}

.product-card h3 {
    font-size: 16px;
    margin-bottom: 8px;
    color: #333;
}

.product-card p {
    font-size: 14px;
    color: #666;
    margin-bottom: 8px;
}

.product-card strong {
    color: #2C3E50;
}

.product-card a {
    display: inline-block;
    padding: 8px 12px;
    background-color: #a71d1d;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 10px;
    transition: background-color 0.3s ease;
}

.product-card a:hover {
    background-color: #911919;
}

</style>
