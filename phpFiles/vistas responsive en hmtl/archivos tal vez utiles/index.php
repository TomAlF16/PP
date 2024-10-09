<?php       
include("conexion.php");

session_start();
//iniciar o restaurar la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contraseña = $_POST['Contrasenia'];
    $email = $_POST['Email'];
    //obtiene los valores de los campos contraseña y email

    $sql = "SELECT id_usuario FROM usuario WHERE email = :email and contraseña = :contrasenia";

    $stmt = $conexion_db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contrasenia', $contraseña);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $_SESSION['login_user'] = $email;
        header("location: dashboard.html");
    } else {
        echo "Contraseña o email incorrectos";
        $error = "Your Login Name or Password is invalid";
    }
}
?>  