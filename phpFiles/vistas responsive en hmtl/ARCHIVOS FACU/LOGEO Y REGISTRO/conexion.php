<?php
try {
    $conexion_db = new PDO("mysql:host=localhost;dbname=base4", "root", "");
    $conexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>