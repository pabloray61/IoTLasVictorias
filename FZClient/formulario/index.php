<?php include('conexion.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario</title>
    </head>

    <body>   
        <h1>Formulario de Registro</h1>
        <h2>Por favor, complete el siguiente formulario:</h2>   
        <h2>Los campos marcados con * son obligatorios</h2>
        <h3>Los datos se enviarán a la misma página</h3>
        <?php   
            date_default_timezone_set('America/Buenos_Aires');
            $fecha_actual = date("Y-m-d H:i:s");
            echo "<h4>Fecha y hora actual: $fecha_actual</h4>"; 
        ?> 


        <br><br>
    
        <form action="conexion.php" method="post">
            <input type="text" name="cedula" placeholder="Cedula"> 
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="text" name="apellidos" placeholder="Apellidos">
            <input tupe="datetime" name="fecha" value="<?=$fecha_actual; ?>" readonly>
            <button type ="submit" name="enviar">Enviar</button>
            <button type ="submit" name="eliminar">Eliminar</button>
        </form>

        <br><br>

        <table>
            <thead>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Fecha</th>
            </thead>
            <tbody>
                <?=cargarTabla($conexion);
                ?>
            </tbody>
        </table>
          
    </body>
</html>