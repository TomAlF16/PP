<?php
include("conexion.php");

// Verificar si se proporcionó el idLibro en la URL
if (!isset($_GET['idLibro'])) {
    echo "ID de producto no proporcionado.";
    exit;
}

$idLibro = (int)$_GET['idLibro'];

// Consultar los detalles del producto
$stmt = $conexion_db->prepare("SELECT * FROM libro WHERE idLibro = ?");
$stmt->execute([$idLibro]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el producto existe
if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}

// Verificar si hay stock disponible para la venta
$hayStock = $producto['stockVenta'] > 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['titulo']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        /* Estilos personalizados */
        :root {
            --burdeos-principal: #7B241C;
            --burdeos-secundario: #A93226;
            --gris-claro: #F5F5F5;
            --texto-claro: #FFFFFF;
            --texto-oscuro: #2C3E50;
            --dorado: #D4AC0D;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--gris-claro);
            color: var(--texto-oscuro);
            margin: 0;
        }

        header {
            background: linear-gradient(135deg, var(--burdeos-principal), var(--burdeos-secundario));
            color: var(--texto-claro);
            padding: 30px 0;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }

        main {
            margin: 50px auto;
            max-width: 1200px;
            padding: 20px;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
        }

        .product-image {
            flex: 1 1 50%;
            max-width: 500px;
            height: auto;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .product-image:hover {
            transform: scale(1.05);
        }

        .product-details {
            flex: 1 1 40%;
            text-align: left;
        }

        .product-details h2 {
            font-size: 2.2rem;
            font-weight: bold;
            color: var(--burdeos-principal);
            margin-bottom: 15px;
        }

        .product-details p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .product-details p strong {
            color: var(--dorado);
        }

        .btn-primary {
            background-color: var(--burdeos-principal);
            border: none;
            padding: 12px 20px;
            font-size: 1.2rem;
            color: var(--texto-claro);
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-transform: uppercase;
        }

        .btn-primary:hover {
            background-color: var(--burdeos-secundario);
            transform: scale(1.05);
        }

        .btn-disabled {
            background-color: gray;
            cursor: not-allowed;
            opacity: 0.6;
        }

        footer {
            background-color: var(--burdeos-principal);
            color: var(--texto-claro);
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }

        footer p {
            margin: 0;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1><?php echo htmlspecialchars($producto['titulo']); ?></h1>
    </header>

    <!-- Detalles del producto -->
    <main>
        <div class="product-container">
            <!-- Imagen del producto -->
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['titulo']); ?>">
            </div>
            
            <!-- Información del producto -->
            <div class="product-details">
                <h2><?php echo htmlspecialchars($producto['titulo']); ?></h2>
                <p><strong>Autor:</strong> <?php echo htmlspecialchars($producto['NombreAutor']); ?></p>
                <p><strong>Stock (Venta):</strong> <?php echo htmlspecialchars($producto['stockVenta']); ?></p>
                <p><strong>Precio Venta:</strong> AR$ <?php echo number_format($producto['PrecioVenta'], 0, ',', '.'); ?></p>
                <p><strong>Descripción:</strong></p>
                <p><?php echo nl2br(htmlspecialchars($producto['Descripcion'])); ?></p>
                
                <?php if ($hayStock): ?>
                    <a href="carrito.php?action=agregar&producto_id=<?php echo $producto['idLibro']; ?>&cantidad=1" class="btn btn-primary">Agregar al carrito</a>
                <?php else: ?>
                    <button class="btn btn-primary btn-disabled" disabled>Sin stock disponible</button>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> La Librería Confiable. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
