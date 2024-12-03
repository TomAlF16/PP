<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
</head>

<body>
    <form action="index.php" method="post">
    <button onclick="history.back()" style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">Atrás</button>


       <main>
        <section>
            <div id="titulo">
                <h1>Iniciar Sesion</h1>
            </div>
            <div id="inicio">
                <form action="">
                    <div id="formulario">
                        <input class="input" type="email" placeholder="Correo Electronico">
                        <input class="input" type="password" placeholder="Contraseña">
                        <input class="input" type="password" placeholder="Confirmar Contraseña">

                        <input class = "siguiente" type="submit" value="Siguiente">

                        <a href="#">¿Has olvidado la contraseña?</a>
                    </div>
                </form>
                 <div class ="registrate">
                    <p>¿No tienes una cuenta?</p>
                    <a href="#">REGISTRATE</a>
                   </div>
                </div>
           </section>
    </form>
    </main>
</body>

</html>