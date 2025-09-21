<?php

require("../conn.php");

	$referente = $_REQUEST["referente"];
	$valor = $_REQUEST["letters"];
		
		$consulta = mysql_query("SELECT CONCAT(apellido, IF(nombre!='', ', ', ''),  IF(nombre !='', nombre, '')) AS nombre FROM clientes WHERE apellido LIKE '".$valor."%' ORDER BY apellido, nombre LIMIT 0, 50");
		$cantidad = mysql_num_rows($consulta);

		if($cantidad==0){
			/* 0: no se vuelve por mas resultados
			vacio: cadena a mostrar, en este caso no se muestra nada */
			echo "0&vacio";
		}else{
			if($cantidad > 20) echo "1&"; 
			else echo "0&";
	
			$cantidad = 1;
			while(($registro = mysql_fetch_row($consulta)) && $cantidad <= 20){
				echo $cantidad."###".$registro[0]."|";
				$cantidad++;
			}
		}
?>