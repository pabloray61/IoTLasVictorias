<?php

    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $basededatos = "formulario";

    $conexion = mysqli_connect($servidor, $usuario, $password, $basededatos) or die("No se ha podido conectar a la Base de Datos");     

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());   
    } else {
        echo "Conexión exitosa a la base de datos.<br><br>";
    }   
    
    diferenciar($conexion);
    
    function diferenciar($conexion){
        if (isset($_POST['enviar'])) {
            insertar($conexion);
        } elseif (isset($_POST['eliminar'])) {
            eliminar($conexion);
        } else {
            echo "No se ha enviado ningún formulario.";
        }
    }
              
    function insertar($conexion){
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $fecha = $_POST['fecha'];
       
        $consulta = "INSERT INTO datos (cedula, nombre, apellidos, fecha) VALUES ('$cedula','$nombre', '$apellidos','$fecha')";
        mysqli_query($conexion, $consulta) or die("Error en la consulta a la base de datos");
        mysqli_close($conexion);
        echo "<br><br>Datos guardados correctamente";
        header("Location: index.php"); // Redirigir a la página principal después de insertar
    }    

    function eliminar($conexion){
        $cedula = $_POST['cedula'];
        $consulta = "DELETE FROM datos WHERE cedula='$cedula'";
        mysqli_query($conexion, $consulta) or die("Error en la consulta a la base de datos");
        mysqli_close($conexion);
        echo "<br><br>Datos eliminados correctamente";
        header  ("Location: index.php"); // Redirigir a la página principal después de eliminar
    }      

    function cargarTabla($conexion){
        $consulta = "SELECT * FROM datos";
        $resultado = mysqli_query($conexion, $consulta) or die("Error en la consulta a la base de datos");
    
        while ($fila = mysqli_fetch_array($resultado)) {
            echo "<tr>";
            echo "<td>" . $fila['cedula'];
            echo "<td>" . $fila['nombre'];
            echo "<td>" . $fila['apellidos'];
            echo "<td>" . $fila['fecha'];
            echo "</tr>";
        }
        mysqli_close($conexion); 
    }
?> 
