<?php   

    require_once('conexion.php');

    date_default_timezone_set('America/Buenos_Aires');
    $estado = 2;

   $conn = new conexion();


         $device = $_GET['device_label'];
         $temperatura = $_GET['temperatura'];
         $humedad = $_GET['humedad'];
         $caudal = $_GET['caudal'];
         $volmin = $_GET['volmin'];
         $volhora = $_GET['volhora'];
         $date = date('Y-m-d H:i:s');
           
         echo "***** DISPOSITIVO: ".$device." *****<br>"; 
         echo "***** TEMPERATURA: ".$temperature." *****<br>";
         echo "***** HUMEDAD: ".$humidity." *****<br>";
         echo "***** CAUDAL: ".$caudal." *****<br>";
         echo "***** VOLMIN: ".$volmin." *****<br>";
         echo "***** VOLHORA: ".$volhora." *****<br>";
         echo "***** FECHA: ".$date." *****<br>";
      
   if(empty($device) || empty($temperatura) || empty($humedad) || empty($caudal) || empty($volmin) || empty($volhora)){
        echo "***** ERROR: FALTAN DATOS *****<br>";
        exit();
   }

   if(!is_numeric($temperatura) || !is_numeric($humedad) || !is_numeric($caudal) || !is_numeric($volmin) || !is_numeric($volhora)){
        echo "***** ERROR: TEMPERATURA O HUMEDAD NO SON NUMERICOS *****<br>";
        exit();
   }  

   $query= "SELECT * FROM device_state WHERE idDevice = '$device'";
   $select = mysqli_query($conn->conectarbd(), $query);
  

      if($select->num_rows){
         
      $query= "UPDATE device_state SET temperatura = $temperatura, humedad = $humedad, caudal = $caudal, volmin = $volmin, volhora = $volhora, fecha = '$date' WHERE idDevice = '$device'";
       $update = mysqli_query($conn->conectarbd(), $query);

        $query= "INSERT INTO device_historic (idDevice, temperatura, humedad, volmin, volhora, fecha) VALUES ('$device', '$temperatura','$humedad', '$volmin', '$volhora','$date')";
        echo $query.'<br>';
        $insert = mysqli_query($conn->conectarbd(), $query);

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
        echo "(TEMPERATURA:  ". $temp1 . ", HUMEDAD: ".$hum1. ", CAUDAL".$caudal1.", VOLUMEN MINUTO: ".$volmin1.", VOLUMEN HORA: ".$volhora1.", SERVO: ".$servo1. ", LED:".$led1.")";
             
     }
   else{
        echo "***** NO EXISTE EL DISPOSITIVO*****<br>";
        echo "***** NO SE REGISTRARON LOS DATOS *****<br>";
   }
?>
