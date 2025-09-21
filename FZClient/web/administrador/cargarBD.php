<?
require("conn2.php");
require("func.php");


// INSERTAR O IMPRIMIR
	//$insertar = "ok";
	$imprimir = "ok";
// ----------------




?>

<html>
<head>

<title>ACORDES .::. Selected Brands .::.</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="menu.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<?
$act = $_REQUEST['act'];
?>
<form action="<?= $_SERVER['PHP_SELF']?>" name="form">
	<select name="act" onChange="javascript: form.submit()">
		<option value="">Seleccionar</option>
		<option value="ventas" <? if($act == 'ventas') echo("SELECTED")?>>Ventas</option>
		<option value="ventas_detalle" <? if($act == 'ventas_detalle') echo("SELECTED")?>>Ventas Detalle</option>
		<option value="abrir_cajas" <? if($act == 'abrir_cajas') echo("SELECTED")?>>Abrir Cajas</option>
		<option value="clientes" <? if($act == 'clientes') echo("SELECTED")?>>Clientes</option>
		<option value="mermas" <? if($act == 'mermas') echo("SELECTED")?>>Mermas</option>
		<option value="pagos" <? if($act == 'pagos') echo("SELECTED")?>>Pagos</option>
		<option value="produccion" <? if($act == 'produccion') echo("SELECTED")?>>Produccion</option>
		<option value="stock" <? if($act == 'stock') echo("SELECTED")?>>Stock</option>
		<option value="transferencia" <? if($act == 'transferencia') echo("SELECTED")?>>Transferencia</option>
	</select>
</form>
<?
if($act == "ventas"){
	$tipo = $_REQUEST['tipo'];
	?>
	<form action="<?= $_SERVER['PHP_SELF']?>" name="forma">
		<input type="hidden" name="act" value="<?= $act?>">
		<select name="tipo" onChange="javascript: forma.submit()">
			<option value="">Seleccionar</option>
			<option value="1" <? if($tipo == 1) echo("SELECTED")?>>Ventas</option>
			<option value="2" <? if($tipo == 2) echo("SELECTED")?>>Visita</option>
			<option value="3" <? if($tipo == 3) echo("SELECTED")?>>Llamado</option>
		</select>
	</form>
	<?
	$d = query("SELECT * FROM ventas");
	while($rs = mysql_fetch_array($d)){
		$operacion = $rs['operacion'];
		if($operacion == $tipo){
			$id_venta = $rs['id_venta'];
			$id_vendedor = $rs['id_vendedor'];
			$id_cliente = $rs['id_cliente']; 
			$id_deposito = $rs['id_deposito']; 
			if($tipo == 1 AND $id_deposito == "") $id_deposito = 5;
			if($tipo != 1 AND $id_deposito == ""){
				$x = query("SELECT * FROM ventas_detalle WHERE id_venta = $id_venta");
				if(mysql_num_rows($x) > 0){ 
					$id_deposito = 5;
				}else{
					$id_deposito = 'NULL';
				}
			}
			if($id_deposito == 0) $id_deposito = 'NULL';
			$fecha = $rs['fecha'];
			$remito = $rs['remito'];
			$factura = $rs['factura'];
			$estado = $rs['estado'];
			$dto_fijo = $rs['dto_fijo'];
			$dto_porc = $rs['dto_porc'];
			$observaciones = $rs['observaciones']; 
			
			if($tipo == 1) echo("INSERT INTO ventas VALUES ($id_venta, $id_vendedor, $id_cliente, $id_deposito, '$fecha', '$remito', $factura, $estado, $dto_fijo, $dto_porc, '$observaciones');<br>");
			if($tipo == 2) echo("INSERT INTO visitas VALUES ($id_venta, $id_vendedor, $id_cliente, $id_deposito, '$fecha', '$observaciones');<br>");
			if($tipo == 3) echo("INSERT INTO llamados VALUES ($id_venta, $id_vendedor, $id_cliente, '$fecha', '$observaciones');<br>");			
		}
	}
}
if($act == "ventas_detalle"){
	$tipo = $_REQUEST['tipo'];
	?>
	<form action="<?= $_SERVER['PHP_SELF']?>" name="forma">
		<input type="hidden" name="act" value="<?= $act?>">
		<select name="tipo" onChange="javascript: forma.submit()">
			<option value="">Seleccionar</option>
			<option value="1" <? if($tipo == 1) echo("SELECTED")?>>Ventas</option>
			<option value="2" <? if($tipo == 2) echo("SELECTED")?>>Visita</option>
		</select>
	</form>
	<?
	if($tipo != ""){
		$a = 1;
		$d = query("SELECT * FROM ventas_detalle vd
					LEFT JOIN ventas v on v.id_venta = vd.id_venta
					WHERE operacion = $tipo");
		while($rs = mysql_fetch_array($d)){
			
			$dto_fijo = $dto_porc = $dto1 = $dto2 = $precio = $precio_final = 0;
			
			$id_vd = $rs['id_vd'];
			$id_venta = $rs['id_venta'];
			$id_producto = $rs['id_producto'];
			$id_p = $rs['id_producto'];
			$cant = $rs['cant']; 
			$precio = $rs['precio']; 
			
			$dto_fijo = round($rs['dto_fijo']*100)/100;
			$dto_porc = round($rs['dto_porc']*100)/100;
			if($dto_fijo > 0) $dto1 = $dto_fijo / $cant;
			if($dto_porc > 0) $dto2 = $precio * $dto_porc / 100;
			
			$precio_final = number_format($precio - $dto1 - $dto2, 2, '.', "");
			//echo("P: ".$precio." - DF: ".$dto_fijo." - DP: ".$dto_porc." - PF: ".$precio_final."<br>");

			$id_producto = chg_id_producto($id_producto);
		
				//if($id_producto != 801 AND $id_producto != 401 AND $id_producto != 700 AND $id_producto != 600 AND $id_producto != 50 AND $id_producto != 504 AND $id_producto != 505 AND $id_producto != 515 AND $id_producto != 450){
					//if($id_producto != $id_p) echo ("--------- OK ------------------------------------");
					if($tipo == 1) echo("INSERT INTO ventas_detalle VALUES (NULL, $id_venta, $id_producto, $cant, $precio, $precio_final);<br>");
					if($tipo == 2) echo("INSERT INTO visitas_detalle VALUES (NULL, $id_venta, $id_producto, $cant, $precio);<br>");
					//if($id_producto != $id_p) echo ("--------- OK ------------------------------------");
					//$p = query("SELECT * FROM productos WHERE id_producto = $id_p");
					//$rp = mysql_fetch_array($p);
					//echo($rp['id_producto']."- ".$rp['producto']."<br><br>");
					$a++;
				//}
		}
		echo("<br><br>Total: ".($a-1));
	}
}

if($act == "abrir_cajas"){

	$d = query("SELECT * FROM abrir");
	while($rs = mysql_fetch_array($d)){
	
		$id_abrir = $rs['id_abrir'];
		$id_producto_c = $rs['id_producto_c'];
		$id_deposito = $rs['id_deposito'];
		$id_producto_b = $rs['id_producto_b'];
		$fecha = $rs['fecha'];
		$cantidad_c = $rs['cantidad_c']; 
		$cantidad_b = $rs['cantidad_b']; 

		//PROD C
		$id_producto_c = chg_id_producto($id_producto_c);
		// PROD B
		$id_producto_b = chg_id_producto($id_producto_b);
		
			if($id_producto != 801 AND $id_producto != 401 AND $id_producto != 700 AND $id_producto != 600 AND $id_producto != 50 AND $id_producto != 504 AND $id_producto != 505 AND $id_producto != 515 AND $id_producto != 450){
				//if($id_producto != $id_p) echo ("--------- OK ------------------------------------");
				echo("INSERT INTO abrir VALUES ($id_abrir, $id_producto_c, $id_deposito, $id_producto_b, '$fecha', $cantidad_c, $cantidad_c);<br>");
				//if($id_producto != $id_p) echo ("--------- OK ------------------------------------");
				//$p = query("SELECT * FROM productos WHERE id_producto = $id_p");
				//$rp = mysql_fetch_array($p);
				//echo($rp['id_producto']."- ".$rp['producto']."<br><br>");
		}
	}
}
if($act == "clientes"){

	echo("DELETE FROM $act;<br><br>"); // borro lo que este cargado
	
	$d = query("SELECT * FROM clientes c
				INNER JOIN tipos t ON t.id_tipo = c.id_tipo
				INNER JOIN listas l ON l.id_lista = t.id_lista");
	$a = 1;
	while($rs = mysql_fetch_array($d)){
	
		$id_cliente = $rs['id_cliente'];
		$name = $rs['nombre'];
		$p = strrpos($name, ", ");
		if($p === false){
			$poe = 2;
			$apellido = "'".$name."'";
			$nombre = 'NULL';
		}else{
			$poe = 1;
			$apellido = "'".substr($name, 0, $p)."'";
			$nombre = "'".substr($name, ($p + 1), strlen($name))."'";
		}
		$sexo = $rs['sexo'];
		$id_tipo = $rs['id_tipo'];
		$mail = $rs['mail'];
		$telefono = $rs['telefono'];
		$direccion = $rs['direccion'];
		$cuit = $rs['cuit'];
		$cp = $rs['cp'];
		$contacto = $rs['contacto'];
		$observaciones = $rs['observaciones'];
		$id_vendedor = $rs['id_vendedor'];
		$celular = $rs['celular'];
		$compra = $rs['compra'];
		$factura = $rs['factura'];
		$saldo = $rs['saldo'];
		$fecha_alta = "'".$rs['fecha_alta']."'";
		if($fecha_alta == "'0001-00-00'" OR $fecha_alta == "'0000-00-00'" OR $fecha_alta == "''") $fecha_alta = 'NULL';
		$fecha_cumple = "'".$rs['fecha_cumple']."'";
		if($fecha_cumple == "'0001-00-00'" OR $fecha_cumple == "'0000-00-00'" OR $fecha_cumple == "''") $fecha_cumple = 'NULL';
		//echo($fecha_cumple." - ".$fecha_alta."(".$rs['fecha_cumple']." - ".$rs['fecha_alta'].")<br>");
		$localidad = $rs['localidad'];
		$id_grupo = $rs['id_grupo'];

		$id_lista = $rs['id_lista'];
		if($id_lista == "") echo('<br><br><br><br><br><br>');
		$id_categoria = $rs['id_tipo'];
		if($id_categoria == "") echo('<br><br><br><br><br><br>');
		
		if($id_tipo == "") $id_tipo = 'NULL';
		if($cp == "") $cp = 'NULL';
		if($dni == "") $dni = 'NULL';
		if($compra == "") $compra = 'NULL';
		if($factura == "") $factura = 'NULL';
		if($id_grupo == "") $id_grupo = 'NULL';
		if($id_vendedor == "") $id_vendedor = 'NULL';

								        // (id_cliente, poe, apellido, nombre, sexo, fecha_cumple, 	   dni,   cuit,     pass,    telefono,    celular, mail,     web,    contacto,    direccion,    localidad,    cp, id_tipo,   id_categoria,  id_lista,  compra,  factura,  saldo, id_grupo,  id_vendedor,  fecha_alta,     referente, observaciones)
		echo("INSERT INTO clientes VALUES ($id_cliente, $poe, $apellido, $nombre, '$sexo', $fecha_cumple, $dni, '$cuit', '$pass', '$telefono', '$celular', '$mail', '$web', '$contacto', '$direccion', '$localidad', $cp, $id_tipo, $id_categoria, $id_lista, $compra, $factura, $saldo, $id_grupo, $id_vendedor, $fecha_alta, '$referente', '$observaciones');<br>");
		$a++;		
	}
	echo("<br><br>Total: ".($a-1));
}

if($act == "mermas"){

	echo("DELETE FROM $act;<br><br>"); // borro lo que este cargado
	
	$a = 1;
	$d = query("SELECT * FROM mermas");
	while($rs = mysql_fetch_array($d)){
	
		$id_merma = $rs['id_merma'];
		$id_producto = $rs['id_producto'];
		$id_deposito = $rs['id_deposito'];
		$fecha = $rs['fecha'];
		$cantidad = $rs['cantidad']; 
		$detalle = $rs['detalle']; 
		
		$id_producto = chg_id_producto($id_producto);
		
			if($id_producto != 801 AND $id_producto != 401 AND $id_producto != 700 AND $id_producto != 600 AND $id_producto != 50 AND $id_producto != 504 AND $id_producto != 505 AND $id_producto != 515 AND $id_producto != 450){
				//if($id_producto != $id_p) echo ("--------- OK ------------------------------------");
				echo("INSERT INTO mermas VALUES ($id_merma, $id_producto, $id_deposito, '$fecha', $cantidad, '$detalle');<br>");
				//if($id_producto != $id_p) echo ("--------- OK ------------------------------------");
				//$p = query("SELECT * FROM productos WHERE id_producto = $id_p");
				//$rp = mysql_fetch_array($p);
				//echo($rp['id_producto']."- ".$rp['producto']."<br><br>");
			}
		$a++;		
	}
	echo("<br><br>Total: ".($a-1));
}

if($act == "pagos"){

	echo("DELETE FROM $act;<br><br>"); // borro lo que este cargado
	
	$d = query("SELECT * FROM pagos");
	$a = 1;
	while($rs = mysql_fetch_array($d)){
	
		$id_pago = $rs['id_pago'];
		$id_venta = $rs['id_venta'];
		$id_vendedor = $rs['id_vendedor'];
		$id_cliente = $rs['id_cliente'];
		$fecha = $rs['fecha'];
		$monto = $rs['monto'];
		$id_modo_pago = $rs['id_modo_pago'];
		$concepto = $rs['concepto'];
		if($concepto == "") $concepto = 'NULL';
		$observaciones = $rs['observaciones'];
		if($observaciones == "") $observaciones = 'NULL';
		
		echo("INSERT INTO pagos VALUES ($id_pago, $id_venta, $id_vendedor, $id_cliente, '$fecha', $monto, $id_modo_pago, $concepto, $observaciones);<br>");
		$a++;		
	}
	echo("<br><br>Total: ".($a-1));
}

if($act == "produccion"){

	echo("DELETE FROM $act;<br><br>"); // borro lo que este cargado
	
	$a = 1;
	$d = query("SELECT * FROM $act");
	while($rs = mysql_fetch_array($d)){
	
		$id_produccion = $rs['id_produccion'];
		$id_producto = $rs['id_producto'];
		$id_deposito = $rs['id_deposito'];
		$fecha = $rs['fecha'];
		$cantidad = $rs['cantidad']; 
		$costo = $rs['costo'];
		$numero = $rs['numero'];
		if($numero == "") $numero = 'NULL';
		$observaciones = $rs['observaciones'];
		
		$id_producto = chg_id_producto($id_producto);
		
			if($id_producto != 801 AND $id_producto != 401 AND $id_producto != 700 AND $id_producto != 600 AND $id_producto != 50 AND $id_producto != 504 AND $id_producto != 505 AND $id_producto != 515 AND $id_producto != 450){
				
				echo("INSERT INTO $act VALUES ($id_produccion, $id_producto, $id_deposito, '$fecha', $cantidad, $costo, $numero, '$observaciones');<br>");
				
				$a++;
			}
	}
	echo("<br><br>Total: ".($a-1));
}

if($act == "stock"){

	echo("DELETE FROM $act;<br><br>"); // borro lo que este cargado
	
	$a = 1;
	$d = query("SELECT * FROM $act");
	while($rs = mysql_fetch_array($d)){
	
		$id_stock = $rs['id_stock'];
		$id_producto = $rs['id_producto'];
		$id_deposito = $rs['id_deposito'];
		$cantidad = $rs['cantidad']; 
		
		$id_producto = chg_id_producto($id_producto);
		
			if($id_producto < 200){
				
				echo("INSERT INTO $act VALUES ($id_stock, $id_deposito, $id_producto, $cantidad);<br>");
				
				$a++;
			}
	}
	echo("<br><br>Total: ".($a-1));
}

if($act == "transferencia"){

	echo("DELETE FROM $act;<br><br>"); // borro lo que este cargado
	
	$a = 1;
	$d = query("SELECT * FROM $act");
	while($rs = mysql_fetch_array($d)){
	
		$id_transferencia = $rs['id_transferencia'];
		$id_producto = $rs['id_producto'];
		$id_deposito_out = $rs['id_deposito_out'];
		$id_deposito_in = $rs['id_deposito_in'];
		$fecha = $rs['fecha']; 
		$cantidad = $rs['cantidad']; 
		$costo = $rs['costo']; 
		
		$id_producto = chg_id_producto($id_producto);
		
			if($id_producto < 200){
				
				echo("INSERT INTO $act VALUES ($id_transferencia, $id_producto, $id_deposito_out, $id_deposito_in, '$fecha', $cantidad, $costo);<br>");
				
				$a++;
			}
	}
	echo("<br><br>Total: ".($a-1));
}

function chg_id_producto($id_producto){

			// VINOS
			if($id_producto == 101) $id_producto = 1;
			if($id_producto == 102) $id_producto = 3;
			if($id_producto == 103) $id_producto = 5;
			if($id_producto == 106) $id_producto = 2;
			if($id_producto == 107) $id_producto = 4;
			if($id_producto == 111) $id_producto = 17;
			if($id_producto == 112) $id_producto = 16;
			if($id_producto == 113) $id_producto = 18;
			if($id_producto == 151) $id_producto = 6;
			if($id_producto == 156) $id_producto = 7;
			if($id_producto == 161) $id_producto = 19;
			if($id_producto == 171) $id_producto = 15;
			
			// CHAMPAGNE
			if($id_producto == 201) $id_producto = 12;
			if($id_producto == 210) $id_producto = 30;
			if($id_producto == 211) $id_producto = 14;
			if($id_producto == 212) $id_producto = 32;
			if($id_producto == 213) $id_producto = 31;
			if($id_producto == 214) $id_producto = 40;
			if($id_producto == 215) $id_producto = 10;
			if($id_producto == 311) $id_producto = 29;
			
			// CRISTALERIA
			if($id_producto == 331) $id_producto = 38;
			if($id_producto == 333) $id_producto = 38;
			
			// EDITORIAL
			if($id_producto == 401) $id_producto = 45;
			
			// ESTUCHE
			if($id_producto == 420) $id_producto = 10;
			if($id_producto == 421) $id_producto = 34;
			if($id_producto == 450) $id_producto = 25;
			if($id_producto == 452) $id_producto = 35;
			if($id_producto == 453) $id_producto = 22;
			if($id_producto == 456) $id_producto = 42;
			if($id_producto == 457) $id_producto = 39;
			if($id_producto == 458) $id_producto = 41;
			if($id_producto == 459) $id_producto = 33;			
			
			// PROMOCION
			if($id_producto == 501) $id_producto = 17;
			if($id_producto == 502) $id_producto = 16;
			if($id_producto == 503) $id_producto = 18;
			if($id_producto == 504) $id_producto = 43;
			if($id_producto == 505) $id_producto = 44;
			if($id_producto == 506) $id_producto = 36;
			if($id_producto == 507) $id_producto = 37;
			if($id_producto == 510) $id_producto = 14;
			if($id_producto == 511) $id_producto = 29;
			if($id_producto == 512) $id_producto = 32;
			if($id_producto == 515) $id_producto = 10;
			if($id_producto == 551) $id_producto = 19;
			if($id_producto == 552) $id_producto = 15;
			if($id_producto == 600) $id_producto = 45;
			if($id_producto == 700) $id_producto = 46;
			if($id_producto == 801) $id_producto = 47;
			
		return $id_producto;
}
?>


</body>
</html>
