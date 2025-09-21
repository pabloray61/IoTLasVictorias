<?php   

    require_once('conexion.php');

    date_default_timezone_set('America/Buenos_Aires');
    $estado = 2;

   $conn = new conexion();

          $cliente = $_GET['cliente'];
          $device = $_GET['device_label'];
          $caudal = $_GET['caudal'];
          $volMin = $_GET['volMin'];
          $volHora = $_GET['volHora'];
          $volDia = $_GET['volDia'];
          $temperatura = $_GET['tempe'];
          $humedad = $_GET['hume'];
          $date = date('Y-m-d H:i:s');
           
          echo "1. CLIENTE: ".$cliente." **<br>"; 
          echo "2. DISPOSITIVO: ".$device." **<br>";
          echo "3. CAUDAL: ".$caudal." **<br>";
          echo "4. VOLUMEN MINUTO: ".$volMin." **<br>";
          echo "5. VOLUMEN HORA: ".$volHora." **<br>";
          echo "6. VOLUMEN DIA: ".$volDia." **<br>";
          echo "7. TEMPERATURA: ".$temperatura." **<br>";
          echo "8. HUMEDAD: ".$humedad." **<br>";     
          echo "9. FECHA: ".$date." **<br>";
      
   if(empty($cliente) || empty($device) || empty($caudal) || empty($volMin) || empty($volHora) || empty($volDia) || empty($temperatura) || empty($humedad))
       {
        echo "***** ERROR: FALTAN DATOS *****<br>";
        exit();
      }

   if(!is_numeric($temperatura) || !is_numeric($humedad) || !is_numeric($caudal) || !is_numeric($volMin) || !is_numeric($volHora)|| !is_numeric($volDia)) {
        echo "***** ERROR: CAUDAL, VOLUMEN MINUTO, VOLUMEN HORA, VOLUMEN DIA, TEMPERATURA Y/O HUMEDAD,  NO SON NUMERICOS *****<br>";
        exit();
   }  

   $query= "SELECT * FROM caudal_state WHERE idCliente = '$cliente' AND idDevice = '$device'";
   $select = mysqli_query($conn->conectarbd(), $query);
  
      if($select->num_rows){
         
          $query= "UPDATE caudal_state SET caudal = $caudal, volumeMin = $volMin, volumeHora = $volHora, volumeDia = $volDia, temperatura = $temperatura, humedad = $humedad, fecha = '$date' WHERE idCliente = '$cliente'";
          echo $query;
          $update = mysqli_query($conn->conectarbd(), $query);

          $query= "INSERT INTO caudal_historic (idCliente, idDevice, caudal, volumeMin, volumeHora, volumeDia, temperatura, humedad, fecha) VALUES ('$cliente', '$device', '$caudal','$volMin','$volHora', '$volDia','$temperatura', '$humedad', '$date')";
          echo $query;
          $insert = mysqli_query($conn->conectarbd(), $query);
          $query= "SELECT idCliente, idDevice, caudal, volumeMin, volumeHora, volumeDia, temperatura, humedad, fecha FROM caudal_state WHERE idCliente = '$cliente' AND idDevice ='$device'";
          $result = mysqli_query($conn->conectarbd(), $query);
          $row = mysqli_fetch_row($result);
          $cliente1 = $row[0];
          $device1 = $row[1];
          $caudal1 = $row[2];
          $volumeMin1 = $row[3];
          $volumeHora1 = $row[4];
          $volumeDia1 = $row[5];
          $temperatura1 = $row[6];
          $humedad1 = $row[7];
          $date1 = $row[7]; 

          echo "SELECCION EN LA BASE:  (CLIENTE: ".$cliente1.", DEVICE: ".$device1.", CAUDAL: ".$caudal1.", VOLUMEN MINUTO: ".$volumeMin1.", VOLUMEN HORA: ".$volumeHora1.", VOLUMEN DIA: ".$volumeDia1.", TEMPERATURA:  ".$temperatura1.", HUMEDAD: ".$humedad1.", FECHA: ".$date1.")";
             
     }
       else{
        echo "***** NO EXISTE EL DISPOSITIVO*****<br>";
        echo "***** NO SE REGISTRARON LOS DATOS *****<br>";
     }
?>
