<?php
// Conectar a la base de datos
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "base4"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los libros desde la base de datos
$sql = "SELECT * FROM libro"; 
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if ($result === false) {
    die("Error en la consulta SQL: " . $conn->error); 
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
        <section class="next-reading">
            <div class="books-container">
                <h3 style="margin-top: -45px; margin-left: -12px;">Descubre tu próxima lectura</h3>
                <div class="books">
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="book">';
                            
                            if (!empty($row['imagen'])) {
                                
                                echo '<img src="./' . $row['imagen'] . '">';
                                
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

                    $conn->close();
                    ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>