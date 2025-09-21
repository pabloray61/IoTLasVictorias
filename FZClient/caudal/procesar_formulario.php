<?php
    require_once('conexion.php');
    
    $conn = new conexion();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['enviar'])) {
            insertar($conn);
        } elseif (isset($_POST['eliminar'])) {
            eliminar($conn);
        } else {
            echo "Acción no reconocida.";
        }
    } 
    
             
    function insertar($conn){
        $idCliente = $_POST['idCliente'];
        $fecha = $_POST['fecha'];
        $marca = $_POST['marca'];
        $capacidad = $_POST['capacidad'];
        $pesoCompra = $_POST['pesoCompra'];
        $idEnvase = $_POST['idEnvase']; 
        echo    "Datos recibidos:<br>";
        echo    "idCliente: $idCliente<br>";   
        echo    "Fecha: $fecha<br>";    
        echo    "Marca: $marca<br>";  
        echo    "Peso Compra: $pesoCompra<br>";    
        echo    "ID Envase: $idEnvase<br>";
       
        $consulta = "INSERT INTO balanza_purchase (idCliente, fechaCompra, marca, capacidad, pesoCompra, idEnvase) VALUES ('$idCliente','$fecha', '$marca','$capacidad','$pesoCompra','$idEnvase')";
        $insert = mysqli_query($conn->conectarbd(), $consulta);
        if (!$insert) {
            die("Error al insertar los datos: " . mysqli_error($conn->conectarbd()));
        }
        echo "Datos insertados correctamente.<br>";
        // Cerrar la conexión a la base de datos
        mysqli_close($conn->conectarbd());
        // No enviar salida antes de header
        header("Location: formulario.php"); // Redirigir a la página principal después de insertar   
        exit();
        }    

    function eliminar($conn){
        $idEnvase = $_POST['idEnvase'];
        $consulta = "DELETE FROM balanza_purchase WHERE idEnvase='$idEnvase'";
        $delete = mysqli_query($conn->conectarbd(), $consulta);
        if (!$delete) {
            die("Error al eliminar el registro: " . mysqli_error($conn->conectarbd()));
        }       
        echo "Registro eliminado correctamente.<br>";
        // Cerrar la conexión a la base de datos        
        mysqli_close($conn->conectarbd());
        // No enviar salida antes de header
        header("Location: formulario.php"); // Redirigir a la página principal después de eliminar
        exit();
    }      

    function cargarTabla($conn){
        $consulta = "SELECT * FROM balanza_purchase ORDER BY fechaCompra DESC";
        $resultado = mysqli_query($conn->conectarbd(), $consulta) or die("Error al consultar la base de datos: " . mysqli_error($conn->conectarbd()));
    
        while ($fila = mysqli_fetch_array($resultado)) { 
            // Mostrar los datos en la tabla
            echo "<tr>";
            echo "<td>" . $fila['idCliente'] . "</td>";
            echo "<td>" . $fila['fechaCompra'] . "</td>";
            echo "<td>" . $fila['marca'] . "</td>";
            echo "<td>" . $fila['capacidad'] . "</td>";
            echo "<td>" . $fila['pesoCompra'] . "</td>";
            echo "<td>" . $fila['idEnvase'] . "</td>";
            echo "</tr>";
        }   
        mysqli_close($conn->conectarbd());
        if (mysqli_num_rows($resultado) == 0) {
            echo "<tr><td colspan='6'>No hay datos disponibles</td></tr>";
            // Si no hay datos, retornar cadena vacía
            // Esto es útil para evitar errores en la tabla si no hay registros         
        return ""; // Retornar cadena vacía si no hay datos
        }
    }
?>