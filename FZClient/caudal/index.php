<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content='width=device-width, initial-scale=1.0'>
  <title>Control de LED</title>
  <link rel="stylesheet" href="estilos.css" />
</head>

<body>

  <center>
    <div>
    <?php
    $temp = 34;
    $hum = 45;
    $estado = 1;
    date_default_timezone_set('America/Buenos_Aires');
    $date = date("Y-m-d H:i:s");
    ?>
 
    <h1>SENSORES WEB</h1>
      <?php
         if($estado=1){  
           echo "<h2>El Led esta ENCENDIDO</h2>";
           echo "<h2>Temperatura: ".$temp."</h2>";
           echo "<h2>Humedad: ".$hum."</h2>";
           echo "<h2>Fecha: ".$date."</h2>";
            }
         else{
            echo "<h2>El Led esta APAGADO</h2>";
            echo "<h2>Temperatura: ".$temp."</h2>";
            echo "<h2>Humedad: ".$hum."</h2>";
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
