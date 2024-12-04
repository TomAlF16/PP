<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "base4";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreCategoria = isset($_POST['nombreCategoria']) ? trim($_POST['nombreCategoria']) : '';
    $rutaDestino = "";

    // Subida de la imagen
    if (isset($_FILES['imagenCategoria']) && $_FILES['imagenCategoria']['error'] === UPLOAD_ERR_OK) {
        $directorio = $_SERVER['DOCUMENT_ROOT'] . '/PP/imagenes_categorias/'; // Ruta física
        $nombreImagen = basename($_FILES['imagenCategoria']['name']);
        $rutaTemporal = $_FILES['imagenCategoria']['tmp_name'];
        $rutaDestino = '/PP/imagenes_categorias/' . $nombreImagen; // Ruta relativa

        // Crear el directorio si no existe
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Mover la imagen al directorio
        if (move_uploaded_file($rutaTemporal, $directorio . $nombreImagen)) {
            echo "Imagen subida correctamente.<br>";
        } else {
            echo "Error al subir la imagen.<br>";
            $rutaDestino = ''; // Limpiar la ruta en caso de error
        }
    } else {
        echo "Error al cargar la imagen. Seleccione un archivo válido.<br>";
    }

    // Validación simple
    if (empty($nombreCategoria)) {
        echo "El nombre de la categoría es obligatorio.<br>";
    } else {
        // Insertar categoría en la base de datos
        $sql = "INSERT INTO categoria (nombre, imagen) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $nombreCategoria, $rutaDestino);

            if ($stmt->execute()) {
                echo "Categoría agregada exitosamente.<br>";
            } else {
                echo "Error al agregar la categoría: " . $stmt->error . "<br>";
            }

            $stmt->close();
        } else {
            echo "Error en la consulta SQL: " . $conn->error . "<br>";
        }
    }
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Categoría</title>
    <style>
        :root {
            --ColorPrincipal: #800202;
            --ColorTextoClaro: #f5f5f5;
            --ColorSecundario: #b22222;
            --ColorFondo: #f0f0f0;
            --ColorBorde: #ccc;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--ColorFondo);
            color: #333;
        }

        nav {
            background-color: var(--ColorPrincipal);
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        nav h2 {
            color: var(--ColorTextoClaro);
            margin: 0;
            font-size: 1.5rem;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        #ParteGris2 {
            background-color: #d9d9d9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        input[type="text"], input[type="file"] {
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

        @media (max-width: 768px) {
            #ParteGris2 {
                width: 90%;
            }

            input[type="text"], input[type="file"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h2>La Librería Confiable - Agregar Categoría</h2>
        </nav>
    </header>

    <main>
        <div id="ParteGris2">
            <h3>Agregar Nueva Categoría</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="nombreCategoria" placeholder="Nombre de la categoría" required>
                <input type="file" name="imagenCategoria" accept="image/*" required>
                <button type="submit">Agregar Categoría</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 La Librería Confiable. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
