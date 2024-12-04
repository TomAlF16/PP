<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "base4";

// Conexión a la base de datos
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);



// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener las categorías desde la base de datos
$sqlCategorias = "SELECT * FROM categoria";
$resultCategorias = $conn->query($sqlCategorias);




// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $precio = isset($_POST['precio']) ? trim($_POST['precio']) : '';
    $precioAlquiler = isset($_POST['precioAlquiler']) ? trim($_POST['precioAlquiler']) : '';
    $stockVenta = isset($_POST['StockVenta']) ? trim($_POST['StockVenta']) : '';
    $stockAlquiler = isset($_POST['StockAlquiler']) ? trim($_POST['StockAlquiler']) : '';
    $nombreAutor = isset($_POST['NombreAutor']) ? trim($_POST['NombreAutor']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';

    $rutaDestino = "";

    // Subida de la imagen
    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        $directorio = $_SERVER['DOCUMENT_ROOT'] . '/PP/imagenes/'; // Ruta física
        $nombreImagen = basename($_FILES['portada']['name']);
        $rutaTemporal = $_FILES['portada']['tmp_name'];
        $rutaDestino = '/PP/imagenes/' . $nombreImagen; // Ruta relativa

        // Verificar si el directorio existe
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true); // Crear el directorio si no existe
        }

        // Verificar si la imagen se subió correctamente
        if (move_uploaded_file($rutaTemporal, $directorio . $nombreImagen)) {
            echo "Imagen subida correctamente.<br>";
        } else {
            echo "Error al subir la imagen.<br>";
            $rutaDestino = ''; // Limpiar la ruta en caso de error
        }
    } else {
        echo "Error al cargar el archivo. Verifique si se seleccionó una imagen válida.<br>";
    }

    // Validación simple
    if (empty($titulo) || empty($precio) || empty($descripcion) || empty($precioAlquiler) || empty($stockVenta) || empty($stockAlquiler) || empty($nombreAutor) || empty($categoria)) {
        echo "Todos los campos son obligatorios.<br>";
    } elseif (!is_numeric($precio) || !is_numeric($precioAlquiler) || !is_numeric($stockVenta) || !is_numeric($stockAlquiler)) {
        echo "El precio y los stocks deben ser números válidos.<br>";
    } else {
        // Preparar la consulta SQL para insertar el libro
        $sql = "INSERT INTO libro (titulo, PrecioVenta, PrecioAlquiler, StockVenta, StockAlquiler, NombreAutor, Descripcion, imagen, idCategoria) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la declaración
        if ($stmt = $conn->prepare($sql)) {
            // Enlazar los parámetros
            $stmt->bind_param("sssssssss", $titulo, $precio, $precioAlquiler, $stockVenta, $stockAlquiler, $nombreAutor, $descripcion, $rutaDestino, $categoria);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "Nuevo libro agregado exitosamente.<br>";
            } else {
                echo "Error al agregar el libro: " . $stmt->error . "<br>";
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            echo "Error en la consulta SQL: " . $conn->error . "<br>";
        }
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Librería Confiable</title>
    <link rel="stylesheet" href="style.css">
    <style>
        :root { 
            --ColorPrincipal: #800202;
            --ColorTextoClaro: #f5f5f5;
            --ColorSecundario: #b22222;
            --ColorFondo: #f0f0f0;
            --ColorBorde: #ccc;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--ColorFondo);
            color: #333;
            line-height: 1.6;
        }

        #title {
            color: var(--ColorTextoClaro);
            margin: 20px auto;
            text-align: center;
            font-size: 2rem;
        }

        nav {
            background-color: var(--ColorPrincipal);
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        header {
            margin-top: 50px;
            text-align: center;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 5%;
            padding: 20px;
        }

        #ParteGris2 {
            border-radius: 10px;
            background-color: #d9d9d9;
            height: auto;
            width: 400px;
            text-align: center;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        input[type="text"], textarea, select {
            width: 90%;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            border: 1px solid var(--ColorBorde);
            margin-bottom: 15px;
            font-size: 1rem;
        }

        button {
            background-color: var(--ColorPrincipal);
            color: var(--ColorTextoClaro);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: var(--ColorSecundario);
        }

        footer {
            background-color: var(--ColorPrincipal);
            color: var(--ColorTextoClaro);
            text-align: center;
            padding: 10px 0;
            margin-top: 40px;
            font-size: 0.9rem;
        }

        /* Opcional: Para pantallas pequeñas */
        @media (max-width: 768px) {
            #ParteGris2 {
                width: 90%;
            }

            input[type="text"], textarea, select {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h2 id="title">La Librería Confiable</h2>
        </nav>
    </header>
    <main>
        <div style="margin-left: 15%;">
            <div id="ParteGris2" style="text-align: center; padding: 20px; background-color: #d9d9d9; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <?php
                if (isset($rutaDestino) && file_exists($_SERVER['DOCUMENT_ROOT'] . $rutaDestino)) {
                    echo '<img src="' . $rutaDestino . '" alt="Imagen del libro" style="max-width: 100%; height: auto; width: 300px; border-radius: 5px;">';
                } else {
                    echo '<img src="https://cdn-icons-png.freepik.com/512/25/25666.png" alt="Imagen por defecto" style="max-width: 100%; height: auto; width: 150px; border-radius: 5px;">';
                }
                ?>
            </div>
        </div>

        <div style="margin-left: 10%; margin-top: 4%;">
            <form action="suibir.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="titulo" placeholder="Ingresar título" required>
                <input type="text" name="precio" placeholder="Ingresar precio" required>
                <input type="text" name="precioAlquiler" placeholder="Ingresar precio de alquiler" required>
                <input type="text" name="StockVenta" placeholder="Ingresar stock de venta" required>
                <input type="text" name="StockAlquiler" placeholder="Ingresar stock de alquiler" required>
                <input type="text" name="NombreAutor" placeholder="Nombre del autor" required>
                <textarea name="descripcion" placeholder="Descripción" required></textarea>

                <!-- Select para categorías -->
                <select name="categoria" required>
    <option value="">Seleccionar categoría</option>
    <?php
    if ($resultCategorias->num_rows > 0) {
        while ($row = $resultCategorias->fetch_assoc()) {
            // Verificar que nombreCategoria no esté vacío
            $nombreCategoria = !empty($row['nombre']) ? $row['nombre'] : 'Categoría sin nombre';
            echo "<option value='" . $row['idCategoria'] . "'>" . htmlspecialchars($nombreCategoria, ENT_QUOTES, 'UTF-8') . "</option>";
        }
    } else {
        echo "<option value=''>No hay categorías disponibles</option>";
    }
    ?>
</select>


                <!-- Cargar imagen -->
                <input type="file" name="portada" accept="image/*" required>

                <button type="submit">Agregar Libro</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 La Librería Confiable. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
