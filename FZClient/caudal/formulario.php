<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario</title>
        <link rel="stylesheet" href="estiloCompra.css" />
        <meta http-equiv="refresh" content="30">
    </head>

    <body>   
        <center>
            <div>
            <h1>FORMULARIO COMPRA GARRAFAS</h1>
            <h2>Ingrese los datos de la compra de garrafas</h2>
            <h3>Los datos se registran en la base de datos</h3>
            <?php   
            date_default_timezone_set('America/Buenos_Aires');
            $fecha_actual = date("Y-m-d H:i:s");
            echo "<h4>Fecha y hora actual: $fecha_actual</h4>"; 
            ?> 
            </div>
            
            <br>
            
            <div>
            <form action="procesar_formulario.php" method="post">
            <input type="text" name="idCliente" placeholder="idCliente" required> <br>
            <input type="datetime-local" name="fecha" value="<?=date('Y-m-d\TH:i', strtotime($fecha_actual)); ?>" readonly><br>
            <input type="text" name="marca" placeholder="Marca Garrafa"><br>
            <input type="text" name="capacidad" placeholder="Capacidad"><br>
            <input type="text" name="pesoCompra" placeholder="Peso Compra"><br>
            <input type="text" name="idEnvase" placeholder="ID Envase"><br><br>
            <button type ="submit" name="enviar">Enviar</button><br>
            <button type ="submit" name="eliminar">Eliminar</button>
          
            </form>
            </div>
        
            <br>

            <div>
            <table>
            <thead>
                <th>idCliente</th>
                <th>Fecha Compra</th>
                <th>Marca</th>
                <th>Capacidad</th>
                <th>Peso Compra</th>
                <th>ID Envase</th>  
            </thead>
            <tbody>
                <?php
                require_once('conexion.php');
                $conn = new conexion();    
                function cargarTabla($conn) {
                    $query = "SELECT idCliente, fechaCompra, marca, capacidad, pesoCompra, idEnvase FROM balanza_purchase";
                    $result = mysqli_query($conn->conectarbd(), $query);
                    
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['idCliente']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['fechaCompra']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['capacidad']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['pesoCompra']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['idEnvase']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay datos disponibles</td></tr>";
                    }                  
                }
                cargarTabla($conn);
                ?>
            </tbody>
        </table>
        </div>      
    </center>
    </body>
</html>