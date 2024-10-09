<?php
include("conexion.php");
session_start();

$user_check = $_SESSION['login_user'];

$stmt = $db->prepare("SELECT idUsuario FROM usuario WHERE email = :user_check");
$stmt->bindParam(':user_check', $user_check);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$id_Usuario = $row['idUsuario'];

$stmt = $db->prepare("SELECT nombre FROM usuario WHERE email = :user_check");
$stmt->bindParam(':user_check', $user_check);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$login_session = $row['nombre'];
?>