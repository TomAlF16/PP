<?php
// Conectar a la base de datos
$servername = "localhost"; // Cambia esto si tu base de datos está en otro servidor
$username = "root"; // Tu nombre de usuario de MySQL
$password = ""; // Tu contraseña de MySQL (deja vacía si no tienes)
$dbname = "base4"; // El nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los libros desde la base de datos
$sql = "SELECT * FROM libro"; // Asegúrate de que 'libros' es el nombre correcto de tu tabla
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if ($result === false) {
    die("Error en la consulta SQL: " . $conn->error); // Mostrar el error de la consulta si falla
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Librería Confiable</title>
    <link rel="stylesheet" href="PAGINA PRINCIPAL CSS.css">
</head>
<body>
    <header>
        <div class="logo">La Librería Confiable</div>
        <div class="search-bar">
            <input type="text" placeholder="Buscar...">
            <button type="submit">🔍</button>
        </div>
    </header>

    <main>
        <div class="imagenes">
            <img src="./IMAGENES PAGINA PRINCIPAL/1.webp" alt="Preventa Exclusiva: Libro + Poster">
            <img src="./IMAGENES PAGINA PRINCIPAL/2.webp" alt="">
        </div>

        <section class="carousel">
            <div class="carousel-item active"></div>
            <div class="carousel-item"></div>
            <div class="carousel-item"></div>
            <div class="carousel-item"></div>
            <div class="carousel-item"></div>
            <div class="carousel-item"></div>
            <div class="carousel-item"></div>
        </section>

        <section class="next-reading">
            <div class="books-container">
                <h3 style="margin-top: -45px; margin-left: -12px;">Descubre tu próxima lectura</h3>
                <div class="books">
                    <?php
                    // Mostrar los libros desde la base de datos
                    if ($result->num_rows > 0) {
                        // Mostrar cada libro
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="book">';
                            // Asegúrate de que la ruta de la imagen sea correcta
                            $image_path = 'imagenes/' . $row['imagen'];
                            // Verifica si la imagen existe antes de mostrarla
                            if (file_exists($image_path)) {
                                echo '<img src="' . $image_path . '" alt="' . $row['titulo'] . '">';
                            } else {
                                echo '<img src="imagenes/default.jpg" alt="Imagen no disponible">';
                            }
                            echo '<p>' . $row['titulo'] . '</p>';
                            echo '<p>' . $row['NombreAutor'] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>No hay libros disponibles.</p>";
                    }

                    // Cerrar la conexión
                    $conn->close();
                    ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>