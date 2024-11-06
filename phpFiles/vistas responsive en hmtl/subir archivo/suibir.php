<?php
// Conexión a la base de datos
$host = "localhost"; // Cambiar si es necesario
$usuario = "root";   // Cambiar si es necesario
$contrasena = "";    // Cambiar si es necesario
$base_de_datos = "base4"; // Cambiar con el nombre de tu base de datos

// Conexión a la base de datos
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $precio = isset($_POST['precio']) ? trim($_POST['precio']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

    // Validación simple
    if (empty($titulo) || empty($precio) || empty($descripcion)) {
        echo "Todos los campos son obligatorios.";
    } elseif (!is_numeric($precio)) {
        echo "El precio debe ser un número válido.";
    } else {
        // Preparar la consulta SQL para insertar el libro
        $sql = "INSERT INTO libro (titulo, PrecioVenta, Descripcion) VALUES (?, ?, ?)";

        // Preparar la declaración
        if ($stmt = $conn->prepare($sql)) {
            // Enlazar los parámetros
            $stmt->bind_param("sss", $titulo, $precio, $descripcion);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "Nuevo libro agregado exitosamente.";
            } else {
                echo "Error al agregar el libro: " . $stmt->error;
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            echo "Error en la consulta SQL: " . $conn->error;
        }
    }
}

// Cerrar la conexión
$conn->close();
?>
<?php
// Conexión a la base de datos
$host = "localhost"; // Cambiar si es necesario
$usuario = "root";   // Cambiar si es necesario
$contrasena = "";    // Cambiar si es necesario
$base_de_datos = "base4"; // Cambiar con el nombre de tu base de datos

// Conexión a la base de datos
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $precio = isset($_POST['precio']) ? trim($_POST['precio']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

    // Validación simple
    if (empty($titulo) || empty($precio) || empty($descripcion)) {
        echo "Todos los campos son obligatorios.";
    } elseif (!is_numeric($precio)) {
        echo "El precio debe ser un número válido.";
    } else {
        // Preparar la consulta SQL para insertar el libro
        $sql = "INSERT INTO libro (titulo, PrecioVenta, Descripcion) VALUES (?, ?, ?)";

        // Preparar la declaración
        if ($stmt = $conn->prepare($sql)) {
            // Enlazar los parámetros
            $stmt->bind_param("sss", $titulo, $precio, $descripcion);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "Nuevo libro agregado exitosamente.";
            } else {
                echo "Error al agregar el libro: " . $stmt->error;
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            echo "Error en la consulta SQL: " . $conn->error;
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
        :root{ 
            --ColorPrincipal: #800202;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        #title {
            color: hsl(0, 11%, 95%);
            margin: 10px;
            display: flex;
        }

        nav {
            background-color: var(--ColorPrincipal);
            height: 90px;
            text-align: center;
            width: 100%;
        }

        header {
            margin-top: 50px;
        }

        main {
            display: block;
            text-align: center;
        }

        #ParteGris2 {
            border-radius: 5px;
            background-color: rgb(207, 205, 205, 255);
            height: 402px;
            width: 368px;
            text-align: center;
            margin-top: 6%;
        }

        input[type="text"], textarea {
            width: 50%;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }

        button {
            background-color: var(--ColorPrincipal);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #b22222;
        }

        footer {
            background-color: var(--ColorPrincipal);
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 40px;
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
            <div id="ParteGris2">
                <div style="text-align: center;">
                    <img src="https://cdn-icons-png.freepik.com/512/25/25666.png" width="150" height="150" style="margin-top: 30%;">
                </div>
            </div>
        </div>

        <div style="margin-left: 10%; margin-top: 6%;">
            <div style="margin-left: 35%; margin-top: -35%;">
                <form action="" method="POST">
                    <input type="text" name="titulo" placeholder="Ingresar título" required>
                </div>
                <div style="margin-left: 35%; margin-top: 3%;">
                    <input type="text" name="precio" placeholder="Ingresar precio" required>
                </div>

                <div style="margin-left: 35%; margin-top: 3%;">
                    <textarea name="descripcion" placeholder="Ingresar descripción" style="width: 50%; height: 150px;" required></textarea>
                </div>

                <div style="margin-left: 35%; margin-top: 3%;">
                    <button type="submit">Agregar Libro</button>
                </div>
            </form>
        </div>

    </main>

    <footer>
        <p>La Librería Confiable - Todos los derechos reservados.</p>
    </footer>
</body>
</html>