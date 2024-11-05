<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>La Libreria Confiable</title>
</head>
<body >
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


    <div class="container">
        <div class="row">
          <div class="col-sm">
            
          </div>
          <div class="col-sm" style="margin-top: 5%">
            <div id="espacioDelUsuario">
                <img src="1077114.png" width="64" height="64" style="margin-top: 1.5%;"> 
                <div style=" margin-top: -4%; margin-left: 8%;">
                    
                <?php
// ELIMINAR 
// $user_check = 'Escroto McBolas'; 

// ELIMINAR 
// $stmt = $conexion_db->prepare("SELECT idCliente, nombre FROM cliente WHERE nombre = :user_check");

// ELIMINAR 
// $stmt->bindParam(':user_check', $user_check);

// Consulta para obtener todos los clientes
$stmt = $conexion_db->prepare("SELECT idCliente, nombre FROM cliente");
$stmt->execute();

// ELIMINAR ESTAS LÍNEAS 
// $row = $stmt->fetch(PDO::FETCH_ASSOC);
// if ($row) {
//     $id_Cliente = $row['idCliente'];
//     $nombre_Cliente = $row['nombre'];
// } else {
//     $id_Cliente = null;
//     $nombre_Cliente = null;
// }

// Obtener todos los clientes
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ELIMINAR ESTE BLOQUE
<?php if ($nombre_Cliente): ?>
    <p>Nombre del cliente: <?php echo htmlspecialchars($nombre_Cliente); ?></p>
<?php else: ?>
    <p>No se encontró el cliente.</p>
<?php endif; ?>
-->

<!-- NUEVO CÓDIGO - Mostrar tabla de clientes -->
<?php if ($clientes && count($clientes) > 0): ?>
    <h2>Lista de Clientes</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?php echo htmlspecialchars($cliente['idCliente']); ?></td>
                <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay clientes registrados en la base de datos.</p>
<?php endif; ?>
                </div>
                <img onclick="mostrar()"  src="png-transparent-gear.png" width="64" height="64" style="margin-top: -3%; margin-left: 90%;"> 
            </div>
          </div>
          <div class="col-sm">
            <div id="espacioDelUsuario2" style="display:none"> <div style="margin-left:20%;">*opcion sin definir*</div></div>
          </div>
        </div>
      </div>




</div>
    <script>
        function mostrar(){
            //document.getElementById("espacioDelUsuario2").style.display="block";
            const espaciodiv = document.getElementById("espacioDelUsuario2");
            if(espaciodiv.style.display==="none" || espaciodiv.style.display === ""){
                espaciodiv.style.display = "block";
            }else{
                espaciodiv.style.display = "none";
            }
        }
        function ocultar(){
            document.getElementById("espacioDelUsuario2").style.display="none";
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>



</html>
