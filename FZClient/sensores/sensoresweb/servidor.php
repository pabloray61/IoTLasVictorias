
<?php
    // Incluir la conexión a la base de datos
    
    require_once('conexion.php');

    date_default_timezone_set('America/Buenos_Aires');

    $conn = new conexion();
    $device = "tarjeta1";
    $estado = 0;

   
        $query= "SELECT temperatura, humedad, caudal, volmin, volhora, servo, led FROM device_state WHERE idDevice ='$device'";    
        $result = mysqli_query($conn->conectarbd(), $query);

        $row = mysqli_fetch_row($result);
        $temp1 = $row[0];
        $hum1 = $row[1]; 
        $caudal1 = $row[2];
        $volmin1 = $row[3];
        $volhora1 = $row[4]; 
        $servo1 = $row[5];
        $led1 = $row[6];
    
        echo "(TEMPERATURA". $temp1 . ", HUMEDAD:".$hum1.", CAUDAL: ".$caudal.", VOLUMEN MINUTO: ".$volmin.", VOLUMEN HORA: ".$volhora.", SERVO: ".$servo1 . ", LED:".$led1.")";

        if($led1 ==0) {
            $estado = 1;}
        else {
            $estado = 1;}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content='width=device-width, initial-scale=1.0'>
  <title>Control de LED</title>
  <link rel="stylesheet" href="estilos.css" />
  <meta http-equiv = refresh content = "30">

</head>

<body>

  <center>
    <div>
    <?php
   
    $date = date("Y-m-d H:i:s");
    ?>
 
    <h1>SENSORES WEB</h1>
      <?php
         if($estado==0){  
           echo "<h2>El Led esta ENCENDIDO</h2>";
           echo "<h2>Tarjeta: ".$device."</h2>";
           echo "<h2>Temperatura: ".$temp1." °C</h2>";
           echo "<h2>Humedad: ".$hum1." %</h2>";
           echo "<h2>Caudal: ".$caudal1." L/min</h2>";
            echo "<h2>Volumen por minuto: ".$volmin1." L/min</h2>";
            echo "<h2>Volumen por hora: ".$volhora1." L/h</h2>";
           echo "<h2>Fecha: ".$date."</h2>";
            }
         else{
            echo "<h2>El Led esta APAGADO</h2>";
            echo "<h2>Tarjeta: ".$device."</h2>";
            echo "<h2>Temperatura: ".$temp1." °C</h2>";
            echo "<h2>Humedad: ".$hum1." %</h2>";
            echo "<h2>Caudal: ".$caudal1." L/min</h2>";
            echo "<h2>Volumen por minuto: ".$volmin1." L/min</h2>";
            echo "<h2>Volumen por hora: ".$volhora1." L/h</h2>";    

            echo "<h2>Fecha: ".$date."</h2>";
            }
        ?>
      <button type='button' onClick=location.href='/LED=OFF'>
        <h2>Apagar</h2>
      </button>
      <button type='button' onClick=location.href='/LED=ON'>
        <h2>Encender</h2>
      </button>
      <button type=submit onClick=location.href='/'>
        <h2>Regresar</h2>
     </div>
   </center>
  </body>
</html>
