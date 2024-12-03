<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>La Libreria Confiable</title>
</head>
<body>
    <header class="col">
        <nav>
            <ul style="display: flex; align-items: center;">
                <li id="title" style="flex: 1; text-align: left;">
                    <div style="width: 415px;
                    height: 52px;
                    background-color: #DBDBDB; color: #464646; font-size: x-large; text-align: center; margin-top: 9px; margin-left: 4%;">
                    <h1 style="margin-top: 5px;" >La Librería Confiable</h1>
                </div>
                </li>


           
                <div class=col style="flex: 2; margin-left: -40%;">
   
                    <div class="search-bar" >
                        <input type="text" placeholder="Buscar..." style="margin-left: -30%; width: 555px; height: 47px;">
                        
                        
                        <button style="background-color: #464646; width:40px; height:40px">🤍</button>
                        <button style="width:159px; height: 51px; background-color: #D7D5D5;">   <img src="https://images.emojiterra.com/google/noto-emoji/unicode-15.1/color/svg/1f6d2.svg" width="25" height="25" style="margin-left: 80%;" 
                   
                            
                            >
                        
                        
                        </button>
                </div>


                        </div>
                    </div>
                </div>
            </ul>
        </nav>
    </header>
    <div class="container text-center">
        <div class="row">
          <div class="col">
            
          </div>
          <div class="col">
            <div style="margin-top:5%">
                <div id="ParteGris">
                    Detalles de la cuenta
                    
                    <div id="ParteBlanca">
                        Nombre: <?php
require_once 'C:/xampp/htdocs/PP/phpFiles/vistas responsive en hmtl/administrar usuarios/conexion.php';

if (!$conexion_db) {
    die("La conexión falló.");
}

$user_check = 'Escroto McBolas'; // Cambia esto al nombre que deseas buscar

// Preparar la consulta
$stmt = $conexion_db->prepare("SELECT idCliente, nombre FROM cliente WHERE nombre = :user_check");
$stmt->bindParam(':user_check', $user_check);
$stmt->execute();

// Ejecutar la consulta
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $id_Cliente = $row['idCliente'];
    $nombre_Cliente = $row['nombre']; // Almacena el nombre del cliente
} else {
    $id_Cliente = null; 
    $nombre_Cliente = null; // Maneja el caso de no encontrar el cliente
}
?>
  <?php if ($nombre_Cliente): ?>
        <p> <?php echo htmlspecialchars($nombre_Cliente); ?></p>
    <?php else: ?>
        <p>No se encontró el cliente.</p>
    <?php endif; ?>
                        <p></p>
                        Email: *E-Mail de usuario*  
                    </div>
                    <button type="button" id="CerrarSesion"> cerrar sesion</button>
                </div>
            </div>
            <div style="margin-top:5%">
                <div id="ParteGris">
                    Informacion general
                    <div id="ParteBlanca">
                        Direccion: *direccion del usuario*
                        <p></p>
                        Metodo de pago: * *
                        <p></p>
                    Telefono: *Numero del telefono*
                    </div>
        
          
        
                <button type="button" id="CerrarSesion"> cerrar sesion</button>
               </div>
            </div>
          </div>
          <div class="col">
            
          </div>
        </div>
      </div>

    




      <!-- <div class="col">
            <div style="margin-left: 40%; margin-top: 35%;">
                <div id="ParteGris">
                    Detalles de la cuenta
                    <div id="ParteBlanca">
                        Nombre: *Nombre de usuario*
                        <p></p>
                        Email: *E-Mail de usuario*  
                    </div>
                <button type="button" id="CerrarSesion"> cerrar sesion</button>
            </div>
        </div>
   

<div class="row">
    <div class="col">

        






      <div style=" margin-top: 40%; margin-left: 40%; position: absolute;">
        <div id="ParteGris">
            Informacion general
            <div id="ParteBlanca">
                Direccion: *direccion del usuario*
                <p></p>
                Metodo de pago: * *
                <p></p>
            Telefono: *Numero del telefono*
            </div>

  

        <button type="button" id="CerrarSesion"> cerrar sesion</button>
       </div>
    </div>

</div>

</div> -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>



</html>




<!-- <ul>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>  
    </ul> -->