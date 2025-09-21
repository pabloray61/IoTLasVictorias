
<?php
    // Incluir la conexión a la base de datos
    
    require_once('conexion.php');

    date_default_timezone_set('America/Buenos_Aires');

    $conn = new conexion();
    $cliente = "cliente1";
    $device = "tarjeta1";
    $estado = 0;
   
    $query= "SELECT peso, temperatura, humedad, latitud, longitud, fecha FROM balanza_state WHERE idDevice ='$device' AND idCliente = '$cliente'";    
    $result = mysqli_query($conn->conectarbd(), $query);
    $row = mysqli_fetch_row($result);
        $peso1 = $row[0];
        $temp1 = $row[1]; 
        $hume1 = $row[2];
        $lat1 = $row[3];
        $lng1 = $row[4]; 
        $fecha1 = $row[5];
          
        echo "(CLIENTE: ".$cliente.", DEVICE: ".$device.", PESO: ".$peso1.", TEMPERATURA: ".$temp1 . ", HUMEDAD:".$hume1.", LATITUD: ".$lat1.", LONGITUD: ".$lng1.", FECHA: ".$fecha1.")";

       
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content='width=device-width, initial-scale=1.0'>
  <title>Control de PESO</title>
  <link rel="stylesheet" href="estilos.css" />
  <meta http-equiv = refresh content = "30">

</head>

<body>

  <center>
    <div>
    <?php
   
    $date = date("Y-m-d H:i:s");
    ?>
 
    <h1>CONTROL DE PESO</h1>
      <?php
         
      echo "<h2>Cliente: ".$cliente."</h2>"; 
      echo "<h2>Peso: ".$peso1." kg</h2>";
      echo "<h2>Temperatura: ".$temp1." °C</h2>";
      echo "<h2>Humedad: ".$hume1." %</h2>";
      echo "<h2>Latitud: ".$lat1."</h2>";
      echo "<h2>Longitud: ".$lng1."</h2>"; 
      echo "<h2>Fecha: ".$fecha1."</h2>";
     
      </center>
  </body>
</html>
