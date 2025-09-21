
<?php
    // Incluir la conexión a la base de datos
    
    require_once('conexion.php');

    date_default_timezone_set('America/Buenos_Aires');

    $conn = new conexion();
    $cliente = "cliente1";
    $device = "tarjeta1";
    $envase = "extra-002";
 
    $query= "SELECT peso, temperatura, humedad, latitud, longitud, fecha FROM balanza_state WHERE idDevice ='$device' AND idCliente = '$cliente'";    
    $result = mysqli_query($conn->conectarbd(), $query);
    $row = mysqli_fetch_row($result);
    if ($row) {
        $peso1 = $row[0];
        $temp1 = $row[1]; 
        $hume1 = $row[2];
        $lat1 = $row[3];
        $lng1 = $row[4]; 
        $fecha1 = $row[5];
    } else {
        $peso1 = $temp1 = $hume1 = $lat1 = $lng1 = $fecha1 = "N/A";
        echo "(No hay datos disponibles para el cliente y dispositivo seleccionados)";
    }

    $query= "SELECT marca, idEnvase, pesoCompra, fechaUso FROM balanza_purchase WHERE idCliente = '$cliente' AND idEnvase = '$envase'";    
    $result = mysqli_query($conn->conectarbd(), $query);
    $row = mysqli_fetch_row($result);
    if ($row) {
        $marca1 = $row[0];
        $idEnvase1 = $row[1]; 
        $pesoCompra1 = $row[2];
        $fechaUso1 = $row[3];
    } else {
        $marca1 = $idEnvase1 = $pesoCompra1 = $fechaUso1 = "N/A";
        echo "(No hay datos disponibles para el envase seleccionado)"; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content='width=device-width, initial-scale=1.0'>
  <title>Control de PESO</title>
  <link rel="stylesheet" href="estilos.css" />
  <meta http-equiv="refresh" content="30">
</head>

<body>
  <center>
    <div>
      <h1>TELEMEDICION DE GARRAFAS</h1>
      <h2>Cliente: <?php echo $cliente; ?></h2>
      <h2>Dispositivo Medición: <?php echo $device; ?></h2>
      <h2>Peso Actual: <?php echo $peso1; ?> gr</h2>
      <h2>ID Envase: <?php echo $idEnvase1; ?></h2>
      <h3>Marca: <?php echo $marca1; ?></h3>  
      <h3>Peso Compra: <?php echo $pesoCompra1; ?> gr</h3>  
      <h3>Temperatura: <?php echo $temp1; ?> °C</h3>
      <h3>Humedad: <?php echo $hume1; ?> %</h3>
      <h3>Latitud: <?php echo $lat1; ?></h3>
      <h3>Longitud: <?php echo $lng1; ?></h3>
      <h3>Fecha: <?php echo $fecha1; ?></h3>
    </div>
  </center>
</body>
</html>
