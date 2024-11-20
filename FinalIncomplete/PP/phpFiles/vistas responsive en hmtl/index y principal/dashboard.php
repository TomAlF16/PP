<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

echo "Bienvenido, " . $_SESSION['email']; // Muestra el correo del usuario
?>