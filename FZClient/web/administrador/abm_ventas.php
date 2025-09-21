<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

	$iva = 1.21; // IVA ------------------------------------------------------------

$id_cliente = $_REQUEST['id_cliente'];
$factura = $_REQUEST['factura'];
$id_deposito = $_REQUEST['id_deposito'];
$remito = $_REQUEST['remito'];
$fecha = $_REQUEST['fecha'];
	list($dia, $mes, $ano) = split( '[/.-]', $fecha);
	$fecha = $ano."-".$mes."-".$dia;
	if($fecha == "--") $fecha = $_REQUEST['fecha'];
$estado = $_REQUEST['estado'];
	if($estado == "") $estado = 0;

// datos para la agenda
$agenda = $_REQUEST['agenda'];
$fecha_a = $_REQUEST['fecha_a'];
	list($dia, $mes, $ano) = split( '[/.-]', $fecha_a);
	$fecha_a = $ano."-".$mes."-".$dia;
$observacion = $_REQUEST['observaciones'];
//---------------------


// IMPRIMIR O INSERTAR LAS CONSULTAS -------------------

$insertar = "ok";		//	INSERT
//$imprimir = "ok";		//	PRINT

// ------------------------------------------------------

if ($_REQUEST['agregar'] == "ok"){ // ------------------------------- AGREGAR ---------------------------
	// CHEQUEO SI HAY STOCK DE PRODUCTOS
	$j = 0;
	while($_REQUEST['id_producto' . $j] > 0){
		$q = query("SELECT * FROM stock WHERE id_producto = ".$_REQUEST['id_producto' . $j]." && id_deposito = $id_deposito");
		$rs = mysql_fetch_array($q);
		$stock = $rs['cantidad'];
		if($stock == "") $stock = 0;
		$cargado = $_REQUEST['c'.$j];
		if($cargado == "") $cargado = 0;

		if($stock >= $cargado && $ck != "no") $ck = "ok";
		if($stock < $cargado) $ck = "no";

		$j++;
		unset($stock, $cargado);
	}

	if($ck == "ok"){
		$cant_prod = $_REQUEST['cant'];
		$dto_fijo = round($_REQUEST['dto_fijo']*100)/100;
		$dto_porc = round($_REQUEST['dto_porc']*100)/100;
		$com_fijo = round($_REQUEST['com_fijo']*100)/100;
		$com_porc = round($_REQUEST['com_porc']*100)/100;
		$sql1 = "INSERT INTO ventas VALUES (NULL, ".$_SESSION["id_vendedor"].", $id_cliente, $id_deposito, '$fecha', '$remito', $factura, $estado, ". $dto_fijo .", ". $dto_porc .", '".$_REQUEST['observaciones']."', NULL, NULL, NULL, NULL, ". $com_fijo .", ". $com_porc .", NULL, NULL, NULL)";
		if($insertar == "ok") query($sql1);
		if($imprimir == "ok") echo $sql1 . "<br>";
		$id = mysql_insert_id();
		$i=0;
		while($_REQUEST['id_producto' . $i] > 0){
			if($_REQUEST['c'.$i] != 0){	
				$precio = $_REQUEST['p'.$i];
				if($factura == 1) $precio = number_format($precio * $iva, 2, '.','');
				$dto1 = 0;
				$dto2 = 0;
				if($dto_fijo > 0) $dto1 = $dto_fijo / $cant_prod;
				if($dto_porc > 0) $dto2 = $precio * $dto_porc / 100;
				$precio_final = $precio - $dto1 - $dto2;
				$regalo = $_REQUEST['r'.$i];
				if($regalo == "") $regalo = 0;
				$sql= "INSERT INTO ventas_detalle VALUES (NULL, $id , ". $_REQUEST['id_producto'.$i] . ", " . round($_REQUEST['c'.$i]) . ", " . $precio .", " . $precio_final . " , $regalo)";
				if($imprimir == "ok") echo $sql . "<br>";
				if($insertar == "ok") query($sql);

				// MODIFICO EL STOCK
				$q = query("SELECT * FROM stock WHERE id_producto = ". $_REQUEST['id_producto'.$i] . " && id_deposito = $id_deposito");
				$rs = mysql_fetch_array($q);
				$c = $rs['cantidad'];
				if($c > $_REQUEST['c'.$i]){		
					$c_s = $c - $_REQUEST['c'.$i];
					$sqls = "UPDATE stock SET cantidad = $c_s where id_producto = ". $_REQUEST['id_producto'.$i] . " && id_deposito = $id_deposito";
					if($insertar == "ok") mysql_query($sqls, $conn_id);
					if($imprimir == "ok") echo($sqls."<br>");
				}
				else{
					$sqls = "DELETE FROM stock where id_producto = ". $_REQUEST['id_producto'.$i] . " && id_deposito = $id_deposito";
					if($insertar == "ok") mysql_query($sqls, $conn_id);
					if($imprimir == "ok") echo($sqls."<br>");
				}
			} // si cantidad > 0
			$i++;
		} // cierro el wile
		$qcl = query("SELECT apellido, nombre FROM clientes WHERE id_cliente = $id_cliente");
		$rs_cl = mysql_fetch_array($qcl);
		$n = $rs_cl["nombre"];
		$a = $rs_cl["apellido"];
		if($n != "") $a = $a . ", " . $n;
		$mss_ok = "La venta al cliente $a se genero correctamente.";
		unset($id_cliente, $id_deposito, $factura, $remito);

		// Guardo los datos en la agenda
		if($_REQUEST['agenda'] == 1){
			$q = query("SELECT id_venta FROM ventas ORDER BY id_venta DESC");
			$rs = mysql_fetch_array($q);
			$id_venta = $rs['id_venta'];
			$id_vendedor = $_SESSION['id_vendedor'];
			$sql_a= "INSERT INTO agenda VALUES (NULL, $id_vendedor, $id_cliente, $id_venta, '$fecha_a', '$observacion')";
			if($imprimir == "ok") echo $sql_a . "<br>";
			if($insertar == "ok") query($sql_a);
		}
		header ("location:listar_ventas.php");
	} // si la cant no supera el stock
	else{
		$mss_no = "Alguno de los productos no posee stock en el deposito seleccionado.";
		unset($cant);
	}
}
?>

<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>

<script language="javascript">
function setReadOnly(i) {
	//alert("r" + i + ": " + eval("document.form2.r" + i + ".value"));
	cant=0;
	total=0;
	if(eval("document.form2.r" + i + ".checked")){
		eval("form2.s" + i + ".value=0");
		//eval("form2.c" + i + ".value=0");		
		eval("document.form2.s"+ i +".disabled = true");
	}else{
		eval("document.form2.s"+ i +".disabled = false");
	}
	actualizar();	
}

function actualizar(){
	i=0;
	cant=0;
	total=0;
	
	while( eval("form2.id_producto" + i + ".value")!=null){
		eval("form2.s" + i + ".value=" + eval("form2.p"+ i +".value") * eval("form2.c"+i+".value"));
		cant+= eval("form2.c"+i+".value")*1;//multiplico x1 para que lo tome con nº y no como str
		if(!eval("document.form2.r" + i + ".checked")){
			total+= eval("form2.p"+ i +".value") * eval("form2.c"+i+".value");
		}
		if(form2.factura.value == 1){		
			iva = (Math.floor((total * 0.21) * 100)/100);
			sub_T = (Math.floor(((total + iva)*(1-form2.dto_porc.value/100)-form2.dto_fijo.value) * 100)/100);
			form2.sub_T.value = total.toFixed(2);
			form2.iva_T.value = iva.toFixed(2);
			form2.cant.value = cant;
			
			dto = total - (total * (1 - form2.dto_porc.value / 100) - form2.dto_fijo.value);
			t = total + iva - dto 
			com = t - (t * (1 - form2.com_porc.value / 100) - form2.com_fijo.value);
				
			to = total - dto + iva;
			form2.total_com.value = com.toFixed(2);
			form2.total.value = to.toFixed(2);
		}else{
			form2.cant.value = cant;
			
			dto = total - (total * (1 - form2.dto_porc.value / 100) - form2.dto_fijo.value);
			t = total - dto
			com = t - (t * (1 - form2.com_porc.value / 100) - form2.com_fijo.value);
			
			to = total - dto;
			
			form2.total_des.value = dto.toFixed(2);
			form2.total_com.value = com.toFixed(2);
			form2.total.value = to.toFixed(2);
		}		
		
		i++;
	}
	
}
function showHide (obj) { 
	if (obj.style.visibility == "hidden") { 
		obj.style.visibility = "visible"; 
	} else { 
		obj.style.visibility = "hidden"; 
	} 
}
</script>
<script language="javascript" src="calendar1.js"></script>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->

<link rel="stylesheet" href="includes/menu.css" type="text/css">
<script type="text/javascript" src="includes/jquery143.js"></script>
<script type='text/javascript' src='includes/menu.js'></script>

<script type="text/javascript" src="js/stmenu.js"></script>
<script type="text/javascript">
<!--
window.onerror=function(m,u,l)
{
	window.status = "Java Script Error: "+m;
	return true;
}
//-->
</script>

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>


<? 
	if($_SESSION['admin'] == "ok") $admin = 1;
	
	$vendedor = $_SESSION['nombre_vend'];
	$exp = explode(",", $vendedor);
	if($exp[1] == ""){
		$n = $exp[0];
	}else{
		$n = $exp[1];
	}
	
	include("_menu.php");
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="121" valign="top">
				<table width="100%" height="121" border="0" cellpadding="0" cellspacing="0" id="HEADER">
					<tr>
						<td width="343" valign="top" class="header-left3">
						  <img src="images/headers/mm-ap.jpg" width="341" height="80">
						  <p class="textToolBar">&nbsp;&nbsp;&nbsp;&nbsp;Bienvenido <?= $n?></p>
						</td>
						<td class="expand3">&nbsp;</td>
						<td width="358" valign="top" class="header-right3">
							<p>&nbsp;<br><br><br></p><p>&nbsp;</p>
					    	<p align="right"><a href="logout.php" class="textToolBarLink">Log out</a>&nbsp;&nbsp;&nbsp;</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
		  <td height="15"><div align="right"></div></td>
		</tr>	
		<tr valign="top">
			<td height="5">
			  <!-- InstanceBeginEditable name="SubMenu" -->
			
			  <!-- InstanceEndEditable -->
			</td>
		</tr>
		<tr><td height="30">&nbsp;</td></tr>
		<tr>
			<td valign="top" height="30">
			  <!-- InstanceBeginEditable name="body" -->
<?
if($mss_no != "") echo("<br><p class='error' align='center'>".$mss_no."</p><br>");
if($mss_ok != "") echo("<br><p class='bien' align='center'>".$mss_ok."</p><br>");
if($mss_ok != ""){
?>
	<table width="600" align="center" cellpadding="0" cellspacing="1" border="0">
		<tr>
			<td width="33%"><a href="imp_nota.php?id_venta=<?= $id_venta?>&factura=<?= $factura?>" class="menu" target="_blank">Imprimir Nota de Pedido</a></td>
			<td width="33%"><a href="imp_remito.php?id_venta=<?= $id_venta?>" class="menu" target="_blank">Imprimir el Remito</a></td>
			<td width="33%"><a href="imp_factura.php?id_venta=<?= $id_venta?>&factura=<?= $factura?>" class="menu" target="_blank">Imprimir la Factura</a></td>
		</tr>
	</table>
<? }?>

<table width="800" align="center" cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td width="5%">&nbsp;</td>
		<td width="30%" class="encabezado">AGENTE: <?=$_SESSION['nombre_vend']?></td>
		<td width="60%" align="right"></td>
		<td width="5%">&nbsp;</td>
	</tr>
	<tr><td colspan="4"></td></tr>
	<tr height="30"><td class="t" colspan="4" align="center">Agregar una venta</td></tr>
	<form method="post" name="formu" action="<?=$_SERVER['PHP_SELF']?>">
		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">Seleccionar cliente:&nbsp;&nbsp;
			  <select name="id_cliente" onChange="formu.submit();">
					  <option>Seleccione un cliente</option>
					  <?
					  if($_SESSION['admin']=="ok") $q = query("SELECT * FROM clientes ORDER BY apellido, nombre");
					  if($_SESSION['admin']!="ok") $q = query("SELECT * FROM clientes WHERE id_vendedor = ".$_SESSION['id_vendedor'] ." ORDER BY apellido, nombre");				  
					  while($rs = mysql_fetch_array($q)){
					  ?>
						<option value="<?=$rs['id_cliente']?>" <?  if($id_cliente == $rs['id_cliente']){ echo "SELECTED";} ?>><?= substr($rs['apellido'].", ".$rs['nombre'], 0, 30)?></option>
					  <? }?>
				  </select>
			</td>
			<td class="c1">&nbsp;</td>
		</tr>
	</form>
	<? if($id_cliente > 0){?>
		<form name="formF" method="post" action="<?=$_SERVER['PHP_SELF']?>">
			<tr>
				<td class="c2">&nbsp;</td>
				<td class="c2" colspan="2">
					<?
					$sql = query("SELECT * FROM clientes WHERE id_cliente= ". $_REQUEST['id_cliente']);
					$rs = mysql_fetch_array($sql);
					
					$direccion = $rs['direccion'];
					$cuit = $rs['cuit'];
					$localidad = $rs['localidad'];
					$mail = $rs['mail'];
					$telefono = $rs['telefono'];
					$id_cliente = $rs['id_cliente'];
					$id_lista = $rs['id_lista'];
				
					$cambio = $_REQUEST['cambio'];
				
					$id_venta = $_REQUEST['id_venta'];
					if($id_venta > 0){
						if($cambio != "ok"){
							$qv = query("SELECT * FROM ventas WHERE id_venta = $id_venta");
							$rsv = mysql_fetch_array($qv);
							$factura = $rsv['factura'];
						}
					}
					else{
						if($factura == ""){
							$factura = $rs['factura'];
						}
					}
					?>
					<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
						<tr><td colspan="4">&nbsp;</td></tr>
						<tr height="25">
							<td class="dataBold">Direccion:</td>
							<td class="data"><?=$direccion?></td>
							<td class="dataBold">Factura:</td>
							<td>
								<select name="factura" onChange="formF.submit();">
									<option value="0">Seleccionar</option>
									<option value="1" <? if($factura == 1){echo " SELECTED ";}?>>Factura A</option>
									<option value="2" <? if($factura == 2){echo " SELECTED ";}?>>Factura B</option>
									<option value="3" <? if($factura == 3){echo " SELECTED ";}?>>Factura C</option>
								</select>
								<input type="hidden" name="cambio" value="ok">
								<input type="hidden" name="id_cliente" value="<?= $id_cliente?>">
								<input type="hidden" name="id_deposito" value="<?= $id_deposito?>">
								<input type="hidden" name="id_venta" value="<?= $_REQUEST['id_venta']?>">
							</td>
						</tr>
						<tr height="25">
							<td width="12%" class="dataBold">Localidad:</td>
							<td width="38%" class="data"><?=$localidad?></td>
							<td width="12%" class="dataBold">CUIT:</td>
							<td width="38%" class="data"><?=$cuit?></td>
						</tr>
						<tr height="25">
							<td class="dataBold">Telefono:</td>
							<td class="data"><?=$telefono?></td>
							<td class="dataBold">Mail:</td>
							<td class="data"><?=$mail?></td>
						</tr>
						<tr><td colspan="4">&nbsp;</td></tr>
					</table>  
				</td>
				<td class="c2">&nbsp;</td>
			</tr>
		</form>
		<form action="<? $_SERVER['PHP_SELF']?>" name="formD" method="post">
			<input type="hidden" name="id_cliente" value="<?= $id_cliente?>">
			<input type="hidden" name="factura" value="<?= $factura?>">
			<?
				if ($_REQUEST['id_venta'] > 0){
					$qv = query("SELECT *, v.observaciones as texto FROM ventas v INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor where v.id_venta=" . $_REQUEST['id_venta']);
					$rsv = mysql_fetch_array($qv);
					
					$fecha = $rsv['fecha'];
						list($ano, $mes, $dia) = split( '[/.-]', $fecha);
						$fecha = $dia."-".$mes."-".$ano;
					$remito = $rsv['remito'];
					//$estado=$rs['estado'];
					$dto_porc = $rsv['dto_porc'];
					$dto_fijo = $rsv['dto_fijo'];
					$observaciones = $rsv['texto'];	
					$tipo_visita = $rsv['tipo_visita'];
					$id_deposito = $rsv['id_deposito'];
			
					$sql_p="SELECT SUM(monto) as monto from pagos where id_venta=" . $_REQUEST['id_venta'];
					$q_p=query($sql_p);
					$rs_p=mysql_fetch_array($q_p);
					
					$sql_m="SELECT round(sum(cant*precio)*(1-dto_porc)-dto_fijo) as monto from ventas_detalle vd inner join ventas v on v.id_venta=vd.id_venta where v.id_venta =" . $_REQUEST['id_venta'];
					$q_m=query($sql_m);
					$rs_m=mysql_fetch_array($q_m);
					
						if($rs_p['monto'] < $rs_m['monto']){
							$estado=0;
						}else if ($rs_p['monto'] == $rs_m['monto']){
							$estado="paid";
						}else{
							$estado=1;
						}
						//echo $estado;
				}else{
			
					$sqlv = "SELECT * FROM vendedores WHERE id_vendedor=" . $_SESSION['id_vendedor'];
					$qv = query($sqlv);
					$rsv = mysql_fetch_array($qv);
					
					if($fecha == "--") $fecha = date("d") ."-".date("m") . "-".date("Y");
					$f2 = substr($fecha, 0, 4);
					if(($f2 - 32) > 0){
						list($ano, $mes, $dia) = split( '[/.-]', $fecha);
						$fecha = $dia."-".$mes."-".$ano;
					} 
					//$remito = "";
			
				}
					if($fecha == "") $fecha = date("d") ."-".date("m") . "-".date("Y");
			?>
			<tr>
				<td class="c1">&nbsp;</td>
				<td class="c1" colspan="2">
					<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
						<tr><td colspan="4">&nbsp;</td></tr>
						<tr height="25">
							<td class="dataBold">N&deg; de orden :</td>
							<td class="data"><input name="remito" type="text" size="9" value="<?=$remito?>" <? if ($_REQUEST['id_venta'] > 0){echo " disabled"; }?>></td>
							<td class="dataBold">Fecha:</td>
							<td class="data"><input name="fecha" type="text" size="10" value="<?= $fecha?>" <? if ($_REQUEST['id_venta'] > 0){echo " disabled"; }?>>&nbsp;<img src="images/cal.gif" onClick="javascript:cal12.popup();"></td>
						</tr>
						<tr height="25">
							<td class="dataBold">Agente</td>
							<td class="data"><?=$rsv['nombre']?></td>
							<td class="dataBold">Mail</td>
							<td class="data"><?=$rsv['mail']?></td>
						</tr>
						<tr height="25">
							<td class="dataBold">Telefono</td>
							<td class="data"><?=$rsv['telefono']?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<script language="javascript">
							var cal12 = new calendar1(document.forms['formD'].elements['fecha']);
							cal12.year_scroll = true;
							cal12.time_comp = false;
						</script>
						<tr><td colspan="4">&nbsp;</td></tr>
					</table>
				</td>
				<td class="c1">&nbsp;</td>
			</tr>
			<?
			$q_deposito = query("SELECT * FROM depositos ORDER BY deposito");
			?>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2" colspan="2">
					<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
						<tr>
							<td width="12%" class="dataBold">Deposito:</td>
							<td width="88%">
							<select name="id_deposito" onChange="formD.submit();">
								<option value="">--------></option>
								<? while($rs_q = mysql_fetch_array($q_deposito)){?>
									<option value="<?= $rs_q['id_deposito']?>" <? if($rs_q['id_deposito'] == $id_deposito) echo("selected")?>><?=$rs_q['deposito']?></option>
								<? }?>
							</select>
						</td></tr>
					</table>
				</td>
				<td class="c2">&nbsp;</td>
			</tr>
		</form>
	<? }?>
	<tr height="15"><td colspan="4" class="t"></td></tr>
</table>
<? if($id_deposito != ""){?>
	<form action="<? $_SERVER['PHP_SELF']?>" name="form2" method="post">
		<input type="hidden" name="id_cliente" value="<?= $id_cliente?>">
		<input type="hidden" name="factura" value="<?= $factura?>">
		<input type="hidden" name="remito" value="<?= $remito?>">
		<input type="hidden" name="fecha" value="<?= $fecha?>">
		<input type="hidden" name="id_deposito" value="<?= $id_deposito?>">
		<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
			<?
			$q_c = query("SELECT p.id_producto, pc.id_categoria, pc.categoria, pl.id_linea, pl.linea FROM productos p
						INNER JOIN stock s ON s.id_producto = p.id_producto
						INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
						INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
						WHERE id_deposito = $id_deposito 
						GROUP BY pc.id_categoria, pl.id_linea 
						ORDER BY pc.orden, p.orden");
			if(mysql_num_rows($q_c)){
				?>
				<tr height="30"><td colspan="8" class="encabezado" align="center">Productos cargados</td></tr>
				<tr height="10"><td colspan="8"></td></tr>
				<?
				$i = 0;
				while($rs_c = mysql_fetch_array($q_c)){
					$id_categoria = $rs_c['id_categoria'];
					$id_linea = $rs_c['id_linea'];
					$categoria = $rs_c['categoria'];
					$linea = $rs_c['linea'];
					?>
					<tr height="30">
						<td width="5%" class="t">&nbsp;</td>
						<td width="50%" class="t"><?= $categoria." - ".$linea?></td>
						<? if($i == 0){?>
							<td width="8%" class="t" align="center">Stock</td>
							<td width="8%" class="t" align="center">Precio</td>
							<td width="8%" class="t" align="center">Cantidad</td>
							<td width="8%" class="t" align="center">Importe</td>
							<td width="8%" class="t" align="center">Regalo</td>
						<? }else{?>
							<td width="40%" class="t" align="center" colspan="5">&nbsp;</td>
						<? }?>
						<td width="5%" class="t">&nbsp;</td>
					</tr>
					<?
					$q_p = query("SELECT p.id_producto, 
								(SELECT SUM(cantidad) FROM stock WHERE id_deposito = $id_deposito AND id_producto = p.id_producto) AS cantidad, 
								concat(pv.variedad, ' - ', pp.presentacion, ' (', pp.unidades, 'x', pp.volumen, ')') AS producto,
								(SELECT precio FROM precios pr 
									INNER JOIN listas l ON l.id_lista = pr.id_lista 
									WHERE id_producto = p.id_producto AND l.id_lista=$id_lista ORDER BY fecha DESC LIMIT 1) AS precio
								FROM productos p
								INNER JOIN stock s ON s.id_producto = p.id_producto
								INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
								INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
								INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
								INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
								WHERE id_deposito = $id_deposito AND p.id_categoria = $id_categoria AND p.id_linea = $id_linea
								ORDER BY p.orden");
					while($rs_p = mysql_fetch_array($q_p)){
						$id_producto = $rs_p['id_producto'];
						$cantidad = $rs_p['cantidad'];
						$precio = $rs_p['precio'];
						if($factura == 1) $precio = round($precio/$iva,2);
						if($precio == 0) $precio = "";
						if($sub == "") $sub = 0;
						$c = $flag ? "c1":"c2";
						$flag = !$flag;
						?>
						<tr height="30">
							<td class="<?= $c?>">&nbsp;</td>
							<td class="<?= $c?>"><?= $rs_p['producto']?><input type="hidden" name="id_producto<?= $i?>" value="<?= $id_producto?>"></td>
							<td class="<?= $c?>" align="center"><?= $cantidad?></td>
							<td class="<?= $c?>" align="center"><input name="p<?= $i?>" value="<?= number_format($precio, 2, ".", ",")?>" type="text" size="4" onChange="actualizar();" class="r"></td>
							<td class="<?= $c?>" align="center"><input name="c<?= $i?>" value="<?= $cant?>" type="text" size="4" onChange="actualizar();" class="r"></td>
							<td class="<?= $c?>" align="center"><input name="s<?= $i?>" value="<?= number_format($sub, 2, ".", ",")?>"  type="text" size="5" readOnly="true" class="r"></td>
							<td class="<?= $c?>" align="center"><input name="r<?= $i?>" value="1"  type="checkbox" class="r" onClick="setReadOnly(<?= $i?>);"></td>
							<td class="<?= $c?>">&nbsp;</td>
						</tr>
					<? 
						$sub_T += $sub;
						$total_cant += $cant;
						$i++;
					}
					?>
				<? } // Cierro el wile de categorias?>
				<tr height="20"><td colspan="8" class="t"></td></tr>
				<tr height="30"><td colspan="8"></td></tr>
				<? if($factura == 1){?>
					<tr height="30">
						<td class="t">&nbsp;</td>
						<td class="t" colspan="4">Sub Totales</td>
						<td class="t">&nbsp;</td>
						<td class="t">&nbsp;</td>
						<td class="t">&nbsp;</td>
					</tr>
					<tr height="40">
						<td class="c1">&nbsp;</td>
						<td class="c1" colspan="2">&nbsp;</td>
						<td class="c1" align="center">Sub Total</td>
						<td class="c1" align="right"></td>
						<td class="c1" align="center"><input name="sub_T" type="text" size="5" value="<?= number_format(round($sub_T,2),2,',', '.')?>"  onChange="actualizar<?= $na?>();"></td>
						<td class="c1">&nbsp;</td>
						<td class="c1">&nbsp;</td>
					</tr>
					<tr height="40">
						<td class="c2">&nbsp;</td>
						<td class="c2" colspan="2">&nbsp;</td>
						<td class="c2" align="center">Iva</td>
						<td class="c2" align="right"></td>
						<td class="c2" align="center"><input name="iva_T" type="text" size="5" value="<?= number_format(round($sub_T * $iva,2),2,',', '.')?>"  onChange="actualizar<?= $na?>();"></td>
						<td class="c2">&nbsp;</td>
						<td class="c2">&nbsp;</td>
					</tr>
				<? }?>
				<tr height="30">
					<td class="t">&nbsp;</td>
					<td class="t" colspan="4">Descuentos</td>
					<td class="t">&nbsp;</td>
					<td class="t">&nbsp;</td>
					<td class="t">&nbsp;</td>
				</tr>
				<tr height="40">
					<td class="c1">&nbsp;</td>
					<td class="c1" colspan="2">&nbsp;</td>
					<td class="c1" align="center">Fijo</td>
					<td class="c1" align="right">$</td>
					<td class="c1" align="center"><input name="dto_fijo" type="text" size="5" value="<?=$dto_fijo?>"  onChange="actualizar<?= $na?>();"></td>
					<td class="c1">&nbsp;</td>
					<td class="c1">&nbsp;</td>
				</tr>
				<tr height="40">
					<td class="c2">&nbsp;</td>
					<td class="c2" colspan="2">&nbsp;</td>
					<td class="c2" align="center">Porcentual</td>
					<td class="c2" align="right">%</td>
					<td class="c2" align="center"><input name="dto_porc" type="text" size="5" value="<?=$dto_porc?>"  onChange="actualizar<?= $na?>();"></td>
					<td class="c2">&nbsp;</td>
					<td class="c2">&nbsp;</td>
				</tr>
                <tr height="30">
					<td class="t">&nbsp;</td>
					<td class="t" colspan="4">Comision</td>
					<td class="t">&nbsp;</td>
					<td class="t">&nbsp;</td>
					<td class="t">&nbsp;</td>
				</tr>
				<tr height="40">
					<td class="c1">&nbsp;</td>
					<td class="c1" colspan="2">&nbsp;</td>
					<td class="c1" align="center">Fijo</td>
					<td class="c1" align="right">$</td>
					<td class="c1" align="center"><input name="com_fijo" type="text" size="5" value="<?=$com_fijo?>"  onChange="actualizar<?= $na?>();"></td>
					<td class="c1">&nbsp;</td>
					<td class="c1">&nbsp;</td>
				</tr>
				<tr height="40">
					<td class="c2">&nbsp;</td>
					<td class="c2" colspan="2">&nbsp;</td>
					<td class="c2" align="center">Porcentual</td>
					<td class="c2" align="right">%</td>
					<td class="c2" align="center"><input name="com_porc" type="text" size="5" value="<?=$com_porc?>"  onChange="actualizar<?= $na?>();"></td>
					<td class="c2">&nbsp;</td>
					<td class="c2">&nbsp;</td>
				</tr>
                <tr height="10"><td colspan="8">&nbsp;</td></tr>
				<tr height="35">
					<td class="t">&nbsp;</td>
					<td class="t" colspan="2">Descuento</td>
					<td class="t" align="center">&nbsp;</td>
					<td class="t" align="center"></td>
					<td class="t" align="center"><input type="text" name="total_des" size="6" value="<?=number_format(round($total_des,2),2,',', '.')?>" readonly="true"></td>
					<td class="t">&nbsp;</td>
					<td class="t">&nbsp;</td>
				</tr>
				<tr height="35">
					<td class="t">&nbsp;</td>
					<td class="t" colspan="2">Total</td>
					<td class="t" align="center">&nbsp;</td>
					<td class="t" align="center"><input type="text" name="cant" value="<?=$total_cant?>" size="3" readonly="true"></td>
					<td class="t" align="center"><input type="text" name="total" size="6" value="<?=number_format(round($total,2),2,',', '.')?>" readonly="true"></td>
					<td class="t">&nbsp;</td>
					<td class="t">&nbsp;</td>
				</tr>
				<tr height="35">
					<td class="t">&nbsp;</td>
					<td class="t" colspan="2">Comision</td>
					<td class="t" align="center">&nbsp;</td>
					<td class="t" align="center"></td>
					<td class="t" align="center"><input type="text" name="total_com" size="6" value="<?=number_format(round($total_com,2),2,',', '.')?>" readonly="true"></td>
					<td class="t">&nbsp;</td>
					<td class="t">&nbsp;</td>
				</tr>
				<tr height="40"><td colspan="8"></td></tr>
				<?
				if($id_venta != ""){
					$q = query("SELECT * FROM agenda WHERE id_venta = $id_venta");
					$count = mysql_num_rows($q);
					if($count > 0){
						$ra = mysql_fetch_array($q);
						$id_agenda = $ra['id_agenda'];
						$fec = $ra['fecha'];
						list($ano, $mes, $dia) = split( '[/.-]', $fec);
						$fec = $dia."-".$mes."-".$ano;
						$s = " checked";
						$v = 2;
						$visibility = "visible";
						echo("<input type='hidden' name='id_agenda' value='$id_agenda'>");
					}
				}
				if($v == "") $v = 1;
				if($visibility == "") $visibility = "hidden";
				if($fec == "00-00-0000") $fec = "";
				if($fec == "--") $fec = "";
				?>
				<tr height="30"><td class="t">&nbsp;</td><td colspan="7" class="t">Observaciones</td></tr>
				<tr height="110">
					<td class="c1">&nbsp;</td>
					<td class="c1" colspan="6"><textarea name="observaciones" cols="115" rows="6"><?= $observaciones?></textarea></td>
					<td class="c1">&nbsp;</td>
				</tr>
				<tr height="40">
					<td class="c2">&nbsp;</td>
					<td class="c2" colspan="2">Agregar a la agenda&nbsp;<input type="checkbox" value="<?= $v?>" name="agenda" onClick="showHide(td);"<?= $s?>></td>
					<td class="c2">&nbsp;</td>
					<td class="c2" colspan="3"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td class="c2" style="visibility: <?= $visibility?>;" id="td">Fecha&nbsp;<input name="fecha_a" type="text" size="10" value="<?= $fec?>">&nbsp;<img src="images/cal.gif" onClick="javascript:cal1.popup();"></td></tr></table></td>
					<td class="c2">&nbsp;</td>
				</tr>
					<script language="javascript">
					var cal1 = new calendar1(document.forms['form2'].elements['fecha_a']);
									cal1.year_scroll = true;
									cal1.time_comp = false;
					</script>
				<?	if($id_venta == ""){?>
						<tr height="50">
							<td colspan="8" width="100%" align="center" class="t">
								<input type="hidden" name="agregar" value="ok">
								<input type="image" name="enviar2" src="images/b_insert.png" alt="Agregar la venta" onClick="return confirm('Estás seguro que queres agregar esta venta?');">
							</td>
						</tr>
				<?	} else{ ?>
						<tr height="50">
							<td colspan="8" width="100%" align="center">
								<input type="image" name="enviar3" src="images/b_insert.png" alt="Modificar la venta" onClick="return confirm('Estás seguro que queres modificar esta venta?');">&nbsp;&nbsp;
							</td>
						</tr>
				<? }?>
			<? }else{ // si no productos?>
				<tr height="50">
					<td class="encabezado" align="center">No hay ningun producto en este deposito.</td>
				</tr>
			<? }?>
		</table>
	</form>
<? }?>
			  <!-- InstanceEndEditable -->
			</td>
		</tr>
		<tr><td vAlign="bottom"></td>
		</tr>
		<tr><td vAlign="top" height="30"></td></tr>
		<tr>
			<td height="44" align="center" valign="bottom">
				<table class="pie" id="FOOTER" height="44" cellSpacing="0" cellPadding="0" width="100%" border="0">
					<tr>
						<td align="center">© 2009 ACORDES SA - Todos los derechos reservados</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>			


</body>
<!-- InstanceEnd --></html>
