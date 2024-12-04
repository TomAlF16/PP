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

// Consultar categorías desde la base de datos
$sql = "SELECT * FROM categoria";
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

        .logo span {
            font-size: 24px;
            font-weight: bold;
        }

        .search-bar input {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .search-bar button {
            padding: 8px 15px;
            background-color: #1ABC9C;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .cart button {
            background-color: #E74C3C;
            border: none;
            padding: 8px 15px;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        /* Carrusel */
        .carousel {
            margin: 20px auto;
            text-align: center;
        }

        .carousel-container {
            width: 90%;
            max-width: 1000px;
            height: 300px;
            overflow: hidden;
            border-radius: 15px;
            margin: auto;
        }

        .carousel-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
        }

        .carousel-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-indicators {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .dot {
            height: 12px;
            width: 12px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
        }

        .dot.active {
            background-color: #1ABC9C;
        }

        /* Categorías */
        .category-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 30px;
        }

        .category-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 200px;
            padding: 15px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .category-card img {
            width: 100%;
            max-height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .category-card h3 {
            font-size: 16px;
            color: #333;
        }

        .category-card a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #a14949;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .category-card a:hover {
            background-color: #911919;
        }
    </style>
</head>
<body>


  <!-- Barra de navegación -->
  <header class="navbar">
  <button onclick="history.back()" style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">Atrás</button>
    <div class="logo">
        <span>📚 La Librería Confiable</span>
    </div>

    <div class="actions">
        <!-- Ícono de Registrarse -->
        <a href="registro.php" title="Registrarse">
            <button style="background-color: #3498DB; margin-right: 10px;">
                👤 Registrarse
            </button>
        </a>
        <!-- Ícono del carrito -->
        <a href="carrito.php" title="Carrito">
            <button>🛒 Carrito</button>
        </a>
    </div>
</header>


  <!-- Carrusel -->
  <section class="carousel">
      <div class="carousel-container">
          <div class="carousel-images">
              <img src="imagenes/imagen1.jpg" alt="Imagen 1">
              <img src="imagenes/imagen1.jpg" alt="Imagen 2">
              <img src="imagenes/imagen1.jpg" alt="Imagen 3">
          </div>
      </div>
      <div class="carousel-indicators">
          <span class="dot" data-index="0"></span>
          <span class="dot" data-index="1"></span>
          <span class="dot" data-index="2"></span>
      </div>
  </section>

  <!-- Sección de categorías -->
  <main class="main-content">
      <section class="categories">
          <h2 style="text-align: center; margin-top: 20px;">📚 Explora nuestras categorías</h2>
          <div class="category-list">
              <?php if ($result->num_rows > 0): ?>
                  <?php while ($row = $result->fetch_assoc()): ?>
                      <div class="category-card">
                          <!-- Imagen genérica o personalizada para cada categoría -->
                          <img style="width:100px;height:100px" src="imagenes categorias/<?php echo $row['nombre'] ?>.jpg" alt="Imagen de categoría">
                          <h3><?= htmlspecialchars($row['nombre']) ?></h3>
                          <a href="categoria.php?idCategoria=<?= $row['idCategoria']; ?>">Ver libros</a>
                      </div>
                  <?php endwhile; ?>
              <?php else: ?>
                  <p style="text-align: center;">No hay categorías disponibles en este momento.</p>
              <?php endif; ?>
          </div>
      </section>
  </main>

  <?php $conn->close(); ?>

  <!-- Carrusel de imágenes -->
  <script>
      let currentIndex = 0;
      const images = document.querySelectorAll('.carousel-images img');
      const dots = document.querySelectorAll('.dot');

      function updateCarousel(index) {
          const offset = -index * 100;
          document.querySelector('.carousel-images').style.transform = `translateX(${offset}%)`;

          dots.forEach(dot => dot.classList.remove('active'));
          dots[index].classList.add('active');
      }

      function nextImage() {
          currentIndex = (currentIndex + 1) % images.length;
          updateCarousel(currentIndex);
      }

      dots.forEach(dot => {
          dot.addEventListener('click', (e) => {
              currentIndex = parseInt(e.target.dataset.index);
              updateCarousel(currentIndex);
          });
      });

      setInterval(nextImage, 5000);
      updateCarousel(currentIndex);
  </script>
</body>
</html>
