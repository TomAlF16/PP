<?php
$host = "localhost";   // o la dirección de tu servidor de base de datos
$dbname = "base4";     // nombre de la base de datos
$username = "root";    // tu usuario de MySQL
$password = "";        // tu contraseña de MySQL

try {
    // Crear una instancia de PDO para la conexión a la base de datos
    $conexion_db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurar PDO para que lance excepciones en caso de error
    $conexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si ocurre un error en la conexión, mostrar el mensaje
    die("Error de conexión: " . $e->getMessage());
}
?>
