<?php   

    require_once('conexion.php');

    date_default_timezone_set('America/Buenos_Aires');
    $estado = 2;

   $conn = new conexion();

          $cliente = $_GET['cliente'];
          $device = $_GET['device_label'];
          $peso = $_GET['peso'];
          $temperatura = $_GET['tempe'];
          $humedad = $_GET['hume'];
          $lat = $_GET['lat'];
          $lng = $_GET['lng'];
          $date = date('Y-m-d H:i:s');
           
          echo "1. CLIENTE: ".$cliente." **<br>"; 
          echo "2. DISPOSITIVO: ".$device." **<br>";
          echo "3. PESO: ".$peso." **<br>";
          echo "4. TEMPERATURA: ".$temperatura." **<br>";
          echo "5. HUMEDAD: ".$humedad." **<br>";     
          echo "6. LATITUD: ".$lat." **<br>";
          echo "7. LONGITUD: ".$lng." **<br>";
          echo "8. FECHA: ".$date." **<br>";
      
   if(empty($cliente) || empty($device) || empty($peso)||empty($temperatura) || empty($humedad) || empty($lat) || empty($lng))
     {
        echo "***** ERROR: FALTAN DATOS *****<br>";
        exit();
     }

   if(!is_numeric($temperatura) || !is_numeric($humedad) || !is_numeric($lat) || !is_numeric($lng))
     {
        echo "***** ERROR: TEMPERATURA, HUMEDAD, LATITUD O LONGITUD NO SON NUMERICOS *****<br>";
        exit();
     }  

   $query= "SELECT * FROM balanza_state WHERE idCliente = '$cliente' AND idDevice = '$device'";
   $select = mysqli_query($conn->conectarbd(), $query);
  
      if($select->num_rows){
         
          $query= "UPDATE balanza_state SET peso = $peso, temperatura = $temperatura, humedad = $humedad, latitud = $lat, longitud = $lng, fecha = '$date' WHERE idCliente = '$cliente'";
          echo $query;
          $update = mysqli_query($conn->conectarbd(), $query);

          $query= "INSERT INTO balanza_historic (idCliente, idDevice, peso, temperatura, humedad, latitud, longitud, fecha) VALUES ('$cliente', '$device', '$peso', '$temperatura', '$humedad', '$lat', '$lng', '$date')";
          echo $query;
          $insert = mysqli_query($conn->conectarbd(), $query);

          $query= "SELECT idCliente, idDevice, peso, temperatura, humedad, latitud, longitud, fecha FROM balanza_state WHERE idCliente = '$cliente' AND idDevice ='$device'";
          $result = mysqli_query($conn->conectarbd(), $query);
          $row = mysqli_fetch_row($result);
          $cliente1 = $row[0];
          $device1 = $row[1];
          $peso1 = $row[2];
          $temperatura1 = $row[3];
          $humedad1 = $row[4];
          $latitud1 = $row[5];
          $longitud1 = $row[6];
          $date1 = $row[7];

          echo "SELECCION EN LA BASE:  (CLIENTE: ".$cliente1.", DEVICE: ".$device1.", PESO: ".$peso1.", TEMPERATURA:  ".$temperatura1.", HUMEDAD: ".$humedad1.", LATIDUD: ".$latitud1.", LONGITUD: ".$longitud1. ", FECHA: ".$date1.")";
             
     }
       else{
        echo "***** NO EXISTE EL DISPOSITIVO*****<br>";
        echo "***** NO SE REGISTRARON LOS DATOS *****<br>";
     }
?>
