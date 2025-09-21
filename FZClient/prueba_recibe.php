<?php   

    require_once('conexion.php');

    date_default_timezone_set('America/Buenos_Aires');
    $estado = 2;

   $conn = new conexion();


         $device = $_GET['device_label'];
         $temperature = $_GET['temperature'];
         $humidity = $_GET['humidity'];
         $date = date("Y-m-d H:i:s");

           
         echo "***** DISPOSITIVO: ".$device." *****<br>"; 
         echo "***** TEMPERATURA: ".$temperature." *****<br>";
         echo "***** HUMEDAD: ".$humidity." *****<br>";
         echo "***** FECHA: ".$date." *****<br>";

      
   if(empty($device) || empty($temperature) || empty($humidity)){
        echo "***** ERROR: FALTAN DATOS *****<br>";
        exit();
   }

   if(!is_numeric($temperature) || !is_numeric($humidity)){
        echo "***** ERROR: TEMPERATURA O HUMEDAD NO SON NUMERICOS *****<br>";
        exit();
   }  


   $query= "SELECT * FROM device_state WHERE idDevice = '$device'";
   $select = mysqli_query($conn->conectarbd(), $query);

        

      if($select->num_rows){
         
        $query= "UPDATE device_state SET temperatura = $temperature, humedad = $humidity WHERE idDevice = '$device'";
        $update = mysqli_query($conn->conectarbd(), $query);

        $query= "INSERT INTO device_historic (idDevice, variable, valor, fecha) VALUES ('$device','temperature', '$temperature', NOW())";    
        $insert = mysqli_query($conn->conectarbd(), $query);

        $query= "INSERT INTO device_historic (idDevice, variable, valor, fecha) VALUES ('$device','humidity', '$humidity', NOW())";  
        $insert = mysqli_query($conn->conectarbd(), $query);
        
        $query= "SELECT temperatura, humedad, servo, led FROM device_state WHERE idDevice ='$device'";    
        $result = mysqli_query($conn->conectarbd(), $query);

        $row = mysqli_fetch_row($result);
        $temp1 = $row[0];
        $hum1 = $row[1]; 
        $servo1 = $row[2];
        $led1 = $row[3];
        echo "(TEMPERATURA:  ". $temp1 . ", HUMEDAD: ".$hum1. ", SERVO: ".$servo1. ", LED:".$led1.")";
             
     }
   else{
        echo "***** NO EXISTE EL DISPOSITIVO*****<br>";
        echo "***** NO SE REGISTRARON LOS DATOS *****<br>";
   }
?>
