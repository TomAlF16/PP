<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    // Si no hay sesión, redirigir a la página de login
    header("Location: login.php");
    exit();
}
?>
