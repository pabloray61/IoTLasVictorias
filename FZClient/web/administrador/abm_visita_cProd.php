<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

	$iva = 1.21; // IVA ------------------------------------------------------------

$id_cliente = $_REQUEST['id_cliente'];

$id_vendedor = $_SESSION['id_vendedor'];
$fecha = $_REQUEST['fecha'];
	list($dia, $mes, $ano) = split( '[/.-]', $fecha);
	$fecha = $ano."-".$mes."-".$dia;
	if($fecha == "--") $fecha = $_REQUEST['fecha'];

$id_deposito = $_REQUEST['id_deposito'];
if($id_deposito == "") $id_deposito = 'NULL';

// datos para la agenda
$agenda = $_REQUEST['agenda'];
$fecha_a = $_REQUEST['fecha_a'];
	list($dia, $mes, $ano) = split( '[/.-]', $fecha_a);
	$fecha_a = $ano."-".$mes."-".$dia;
$observaciones = $_REQUEST['observaciones'];
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
		$id_vendedor = $_SESSION["id_vendedor"];
		$sql1 = "INSERT INTO visitas VALUES (NULL, $id_vendedor, $id_cliente, $id_deposito, '$fecha', '".$_REQUEST['observaciones']."')";
		if($insertar == "ok") query($sql1);
		if($imprimir == "ok") echo $sql1 . "<br>";
		$id = mysql_insert_id();
		$i=0;
		while($_REQUEST['id_producto' . $i] > 0){
			if($_REQUEST['c'.$i] != 0){	
				$precio = $_REQUEST['p'.$i];
				$sql= "INSERT INTO visitas_detalle VALUES (NULL, $id , ". $_REQUEST['id_producto'.$i] . ", " . round($_REQUEST['c'.$i]) . ", " . $precio .")";
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
		$mss_ok = "La visita al cliente $a se genero correctamente.";
	
		// Guardo los datos en la agenda
		if($_REQUEST['agenda'] == 1){
			$id_vendedor = $_SESSION['id_vendedor'];
			$sql_a= "INSERT INTO agenda VALUES (NULL, $id_vendedor, $id_cliente, 0, '$fecha_a', '$observacion')";
			if($imprimir == "ok") echo $sql_a . "<br>";
			if($insertar == "ok") query($sql_a);
		}
		unset($id_cliente, $id_deposito, $factura, $remito);
		header ("location:listar_seguimientos.php");
		
	}else{
		$mss_no = "Alguno de los productos no posee stock en el deposito seleccionado.";
		unset($cant);
	}
}
if ($_REQUEST['modificar'] == "ok"){ // ------------------------------- MODIFICAR ---------------------------

	$id_vendedor = $_SESSION["id_vendedor"];
	$sql1 = "UPDATE visitas SET fecha= '$fecha', observaciones= '$observaciones' WHERE id_visita= ".$_REQUEST['id_visita'];
	if($insertar == "ok") query($sql1);
	if($imprimir == "ok") echo $sql1 . "<br>";

	// Guardo los datos en la agenda
	if($_REQUEST['agenda'] == 1){
		$id_vendedor = $_SESSION['id_vendedor'];
		$sql_a= "INSERT INTO agenda VALUES (NULL, $id_vendedor, $id_cliente, 0, '$fecha_a', '$observaciones')";
		if($imprimir == "ok") echo $sql_a . "<br>";
		if($insertar == "ok") query($sql_a);
	}
	unset($id_cliente, $id_deposito, $factura, $remito);
	header ("location:listar_seguimientos.php");
}

?>

<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>

<script language="javascript">
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

if($_REQUEST['ver'] != "modificar"){
?>
	<table width="800" align="center" cellpadding="0" cellspacing="1" border="0">
		<tr>
			<td width="5%">&nbsp;</td>
			<td width="30%" class="encabezado">AGENTE: <?=$_SESSION['nombre_vend']?></td>
			<td width="60%" align="right"></td>
			<td width="5%">&nbsp;</td>
		</tr>
		<tr><td colspan="4"></td></tr>
		<tr height="30"><td class="t" colspan="4" align="center">Agregar una Visita</td></tr>
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
					
						$cambio = $_REQUEST['cambio'];
					
						if($factura == 1 || $factura == 2 || $factura == 3){
							$factura = $rs['factura'];
							if($factura == 1) $factura = "Factura A";
							if($factura == 2) $factura = "Factura B";
							if($factura == 3) $factura = "Factura C";
						}else{
							$factura = "";
						}
						?>
						<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr><td colspan="4">&nbsp;</td></tr>
							<tr height="25">
								<td class="dataBold">Direccion:</td>
								<td class="data"><?=$direccion?></td>
								<td class="dataBold">Factura:</td>
								<td class="data"><?= $factura?></td>
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
			<form action="<? $_SERVER['PHP_SELF']?>" name="formul" method="post">
				<input type="hidden" name="id_cliente" value="<?= $id_cliente?>">
				<?
				$q_deposito = query("SELECT * FROM depositos ORDER BY deposito");
				?>
				<tr height="30">
					<td class="c1">&nbsp;</td>
					<td class="c1" colspan="2">
						<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td width="40%" class="dataBold">Si dejo productos seleccione el deposito:</td>
								<td width="60%">
								<select name="id_deposito" onChange="formul.submit();">
									<option value="">--------></option>
									<? while($rs_q = mysql_fetch_array($q_deposito)){?>
										<option value="<?= $rs_q['id_deposito']?>" <? if($rs_q['id_deposito'] == $id_deposito) echo("selected")?>><?=$rs_q['deposito']?></option>
									<? }?>
								</select>
							</td></tr>
						</table>
					</td>
					<td class="c1">&nbsp;</td>
				</tr>
			</form>
			<form action="<? $_SERVER['PHP_SELF']?>" name="formD" method="post">
				<input type="hidden" name="id_deposito" value="<?= $id_deposito?>">
				<input type="hidden" name="id_cliente" value="<?= $id_cliente?>">
				<?					
				$sqlv = "SELECT * FROM vendedores WHERE id_vendedor=" . $_SESSION['id_vendedor'];
				$qv = query($sqlv);
				$rsv = mysql_fetch_array($qv);
				
				if($fecha == "--") $fecha = date("d") ."-".date("m") . "-".date("Y");
				$f2 = substr($fecha, 0, 4);
				if(($f2 - 32) > 0){
					list($ano, $mes, $dia) = split( '[/.-]', $fecha);
					$fecha = $dia."-".$mes."-".$ano;
				}
				
				if($fecha == "") $fecha = date("d") ."-".date("m") . "-".date("Y");
				?>
				<tr>
					<td class="c2">&nbsp;</td>
					<td class="c2" colspan="2">
						<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr><td colspan="4">&nbsp;</td></tr>
							<tr height="25">
								<td class="dataBold">Agente:</td>
								<td class="data"><?= $_SESSION['nombre_vend']?></td>
								<td class="dataBold">Fecha:</td>
								<td class="data"><input name="fecha" type="text" size="10" value="<?= $fecha?>" <? if ($_REQUEST['id_venta'] > 0){echo " disabled"; }?>>&nbsp;<img src="images/cal.gif" onClick="javascript:cal12.popup();"></td>
							</tr>
							<tr height="25">
								<td class="dataBold">Telefono</td>
								<td class="data"><?=$rsv['telefono']?></td>
								<td class="dataBold">Mail</td>
								<td class="data"><?=$rsv['mail']?></td>
							</tr>
							<tr><td colspan="4">&nbsp;</td></tr>
						</table>
					</td>
					<td class="c2">&nbsp;</td>
				</tr>
				<? 
				if($id_deposito != ""){
					$q_c = query("SELECT p.id_producto, pc.id_categoria, pc.categoria, pl.id_linea, pl.linea FROM productos p
								INNER JOIN stock s ON s.id_producto = p.id_producto
								INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
								INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
								WHERE id_deposito = $id_deposito 
								GROUP BY pc.id_categoria, pl.id_linea 
								ORDER BY pc.orden, p.orden");
					if(mysql_num_rows($q_c)){
					?>
						<tr height="10"><td colspan="4" class="t"></td></tr>
						<tr>
							<td colspan="4">
								<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
									<tr height="30"><td colspan="5" class="encabezado" align="center">Productos cargados</td></tr>
									<tr height="10"><td colspan="5"></td></tr>
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
												<td width="10%" class="t" align="center">Stock</td>
												<td width="10%" class="t" align="center">Cantidad</td>
											<? }else{?>
												<td width="40%" class="t" align="center" colspan="2">&nbsp;</td>
											<? }?>
											<td width="5%" class="t">&nbsp;</td>
										</tr>
										<?
										$q_p = query("SELECT p.id_producto, 
													(SELECT SUM(cantidad) FROM stock WHERE id_deposito = $id_deposito AND id_producto = p.id_producto) AS cantidad, 
													concat(pv.variedad, ' - ', pp.presentacion, ' (', pp.unidades, 'x', pp.volumen, ')') AS producto,
													(SELECT precio FROM precios pr
														INNER JOIN listas l ON l.id_lista = pr.id_lista
														INNER JOIN tipos t ON t.id_lista = l.id_lista
														INNER JOIN clientes c ON c.id_tipo = t.id_tipo
														WHERE id_cliente = $id_cliente AND id_producto = p.id_producto LIMIT 1) AS precio
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
											<input name="p<?= $i?>" value="<?= $precio?>" type="hidden">
											<tr height="30">
												<td class="<?= $c?>">&nbsp;</td>
												<td class="<?= $c?>"><?= $rs_p['producto']?><input type="hidden" name="id_producto<?= $i?>" value="<?= $id_producto?>"></td>
												<td class="<?= $c?>" align="center"><?= $cantidad?></td>
												<td class="<?= $c?>" align="center"><input name="c<?= $i?>" value="<?= $cant?>" type="text" size="4"></td>
												<td class="<?= $c?>">&nbsp;</td>
											</tr>
										<? 
											$sub_T += $sub;
											$total_cant += $cant;
											$i++;
										}
										?>
									<? } // Cierro el wile de categorias?>
									<tr height="20"><td colspan="7" class="t"></td></tr>
									<tr height="30"><td colspan="7"></td></tr>
								</table>
							</td>
						</tr>
					<? } // Cierro el if?>
				<? }?>
				<?
				if($v == "") $v = 1;
				if($visibility == "") $visibility = "hidden";
				if($fec == "00-00-0000") $fec = "";
				if($fec == "--") $fec = "";
				?>
				<tr height="30"><td class="t" colspan="4" align="center">&nbsp;&nbsp;Observaciones</td></tr>
				<tr height="110">
					<td class="c1">&nbsp;</td>
					<td class="c1" colspan="2" align="center"><textarea name="observaciones" cols="114" rows="6"></textarea></td>
					<td class="c1">&nbsp;</td>
				</tr>
				<tr height="40">
					<td class="c2">&nbsp;</td>
					<td class="c2" colspan="2">
						<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
							<tr>
								<td width="30%" class="c2">&nbsp;&nbsp;Agregar a la agenda&nbsp;<input type="checkbox" value="<?= $v?>" name="agenda" onClick="showHide(td);"<?= $s?>></td>
								<td width="70%" class="c2" style="visibility: <?= $visibility?>;" id="td">Fecha&nbsp;<input name="fecha_a" type="text" size="10" value="<?= $fec?>">&nbsp;<img src="images/cal.gif" onClick="javascript:cal1.popup();"></td>
							</tr>
						</table>
					</td>
					<td class="c2">&nbsp;</td>
				</tr>
					<script language="javascript">
					var cal12 = new calendar1(document.forms['formD'].elements['fecha']);
						cal12.year_scroll = true;
						cal12.time_comp = false;
					var cal1 = new calendar1(document.forms['formD'].elements['fecha_a']);
						cal1.year_scroll = true;
						cal1.time_comp = false;
					</script>
				<tr height="50">
					<td colspan="4" width="100%" align="center" class="t">
						<input type="hidden" name="agregar" value="ok">
						<input type="image" name="enviar2" src="images/b_insert.png" alt="Agregar la visita" onClick="return confirm('Estás seguro que queres agregar esta visita?');">
					</td>
				</tr>
			</form>
		<? }else{?>
			<tr height="15"><td colspan="4" class="t"></td></tr>
		<? }?>
	</table>
<? }else{ // MODIFICAR?>
	<form method="post" name="modificar" action="<?=$_SERVER['PHP_SELF']?>">
		<?
		$id_visita = $_REQUEST['id_visita'];
		$q = query("SELECT c.id_cliente, c.apellido, c.nombre, c.factura, c.localidad, c.cuit, c.dni, c.telefono, c.mail, ve.nombre AS agente, 
					ve.telefono AS tel_agente, ve.mail AS mail_agente, v.fecha, v.observaciones, v.id_deposito FROM visitas v
					INNER JOIN clientes c ON c.id_cliente = v.id_cliente
					INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor
					WHERE id_visita = $id_visita");
		$rs = mysql_fetch_array($q);
		
		$id_cliente = $rs['id_cliente'];
		$n = $rs['nombre'];
		$a = $rs['apellido'];
		if($n != "") $a = $a.", ".$n;
		
		$direccion = $rs['direccion'];
		$cuit = $rs['cuit'];
		$dni = $rs['dni'];
		if($cuit != "") $t = "CUIT";
		if($cuit == "") $t = "DNI";
		if($cuit == "") $cuit = $dni;
		$localidad = $rs['localidad'];
		$mail = $rs['mail'];
		$telefono = $rs['telefono'];
		
		$id_deposito = $rs['id_deposito'];

		if($factura == 1 || $factura == 2 || $factura == 3){
			$factura = $rs['factura'];
			if($factura == 1) $factura = "Factura A";
			if($factura == 2) $factura = "Factura B";
			if($factura == 3) $factura = "Factura C";
		}else{
			$factura = "";
		}
		$agente = $rs['agente'];
		$tel_agente = $rs['tel_agente'];
		$mail_agente = $rs['mail_agente'];
		$fecha = $rs['fecha'];
		list($ano, $mes, $dia) = split( '[/.-]', $fecha);
		$fecha = $dia."-".$mes."-".$ano;
		$observaciones = $rs['observaciones'];
		?>
		<table width="800" align="center" cellpadding="0" cellspacing="1" border="0">
			<tr>
				<td width="5%">&nbsp;</td>
				<td width="30%" class="encabezado">AGENTE: <?=$_SESSION['nombre_vend']?></td>
				<td width="60%" align="right"></td>
				<td width="5%">&nbsp;</td>
			</tr>
			<tr><td colspan="4"></td></tr>
			<tr height="30"><td class="t" colspan="4" align="center">Modificar una Visita</td></tr>
			<tr height="40">
				<td class="c1">&nbsp;</td>
				<td class="c1" colspan="2">
					<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
						<tr><td colspan="4" class="c1">Cliente&nbsp;&nbsp;<?= $a?></td></tr>
					</table>
				</td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr>
				<td class="c2">&nbsp;</td>
				<td class="c2" colspan="2">
					<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
						<tr><td colspan="4">&nbsp;</td></tr>
						<tr height="25">
							<td class="dataBold">Direccion:</td>
							<td class="data"><?=$direccion?></td>
							<td class="dataBold">Factura:</td>
							<td class="data"><?= $factura?></td>
						</tr>
						<tr height="25">
							<td width="12%" class="dataBold">Localidad:</td>
							<td width="38%" class="data"><?=$localidad?></td>
							<td width="12%" class="dataBold"><?= $t?>:</td>
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
			<tr>
				<td class="c1">&nbsp;</td>
				<td class="c1" colspan="2">
					<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
						<tr><td colspan="4">&nbsp;</td></tr>
						<tr height="25">
							<td class="dataBold">Agente:</td>
							<td class="data"><?= $_SESSION['nombre_vend']?></td>
							<td class="dataBold">Fecha:</td>
							<td class="data"><input name="fecha" type="text" size="10" value="<?= $fecha?>">&nbsp;<img src="images/cal.gif" onClick="javascript:cal12.popup();"></td>
						</tr>
						<tr height="25">
							<td class="dataBold">Telefono</td>
							<td class="data"><?= $tel_agente?></td>
							<td class="dataBold">Mail</td>
							<td class="data"><?= $mail_agente?></td>
						</tr>
						<tr><td colspan="4">&nbsp;</td></tr>
					</table>
				</td>
				<td class="c1">&nbsp;</td>
			</tr>
				<? 
				if($id_deposito != ""){
					$q_c = query("SELECT p.id_producto, vd.cant AS cantidad, 
								concat(pc.categoria, ' - ', pl.linea) AS categoria,
								concat(pv.variedad, ' - ', pp.presentacion, ' (', pp.unidades, 'x', pp.volumen, ')') AS producto
								FROM visitas_detalle vd
								INNER JOIN productos p ON p.id_producto = vd.id_producto
								INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
								INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
								INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
								INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
								WHERE id_visita = $id_visita");
					if(mysql_num_rows($q_c)){
					?>
						<tr height="10"><td colspan="4" class="t"></td></tr>
						<tr>
							<td colspan="4">
								<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
									<tr height="30"><td colspan="5" class="encabezado" align="center">Productos regalados en la visita</td></tr>
									<tr height="10"><td colspan="5"></td></tr>
									<tr height="30">
										<td width="5%" class="t">&nbsp;</td>
										<td width="40%" class="t">Categoria</td>
										<td width="40%" class="t">Producto</td>
										<td width="10%" class="t" align="center">Cantidad</td>
										<td width="5%" class="t">&nbsp;</td>
									</tr>
									<?
									$i = 0;
									while($rs_c = mysql_fetch_array($q_c)){
										$categoria = $rs_c['categoria'];
										$linea = $rs_c['linea'];
										$producto = $rs_c['producto'];
										$cantidad = $rs_c['cantidad'];
										$precio = $rs_c['precio'];
										$c = $flag ? "c1":"c2";
										$flag = !$flag;
										?>
										<tr height="30">
											<td class="<?= $c?>">&nbsp;</td>
											<td class="<?= $c?>"><?= $categoria?></td>
											<td class="<?= $c?>"><?= $producto?></td>
											<td class="<?= $c?>" align="center"><?= $cantidad?></td>
											<td class="<?= $c?>">&nbsp;</td>
										</tr>
									<? } // Cierro el wile de categorias?>
									<tr height="20"><td colspan="5" class="t"></td></tr>
									<tr height="30"><td colspan="5"></td></tr>
								</table>
							</td>
						</tr>
					<? } // Cierro el if?>
				<? }?>
			<?
			if($v == "") $v = 1;
			if($visibility == "") $visibility = "hidden";
			if($fec == "00-00-0000") $fec = "";
			if($fec == "--") $fec = "";
			?>
			<tr height="30"><td class="t" colspan="4" align="center">&nbsp;&nbsp;Observaciones</td></tr>
			<tr height="110">
				<td class="c1">&nbsp;</td>
				<td class="c1" colspan="2" align="center"><textarea name="observaciones" cols="114" rows="6"><?= $observaciones?></textarea></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="40">
				<td class="c2">&nbsp;</td>
				<td class="c2" colspan="2">
					<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
						<tr>
							<td width="30%" class="c2">&nbsp;&nbsp;Agregar a la agenda&nbsp;<input type="checkbox" value="<?= $v?>" name="agenda" onClick="showHide(td);"<?= $s?>></td>
							<td width="70%" class="c2" style="visibility: <?= $visibility?>;" id="td">Fecha&nbsp;<input name="fecha_a" type="text" size="10" value="<?= $fec?>">&nbsp;<img src="images/cal.gif" onClick="javascript:cal1.popup();"></td>
						</tr>
					</table>
				</td>
				<td class="c2">&nbsp;</td>
			</tr>
				<script language="javascript">
					var cal1 = new calendar1(document.forms['modificar'].elements['fecha_a']);
						cal1.year_scroll = true;
						cal1.time_comp = false;
					var cal12 = new calendar1(document.forms['modificar'].elements['fecha']);
						cal12.year_scroll = true;
						cal12.time_comp = false;
				</script>
			<tr height="50">
				<td colspan="4" width="100%" align="center" class="t">
					<input type="hidden" name="modificar" value="ok">
					<input type="hidden" name="id_visita" value="<?= $_REQUEST['id_visita']?>">
					<a href="listar_seguimientos.php?buscar=<?= $_REQUEST['buscar']?>&mes=<?= $_REQUEST['mes']?>, ano=<?= $_REQUEST['ano']?>, fecha_d=<?= $_REQUEST['fecha_d']?>, fecha_h=<?= $_REQUEST['fecha_h']?>" onClick="return confirm('Estás seguro que queres volver sin guardar los cambios?');"><img src="images/b_back.png" width="30" height="30" border="0" alt="Volver al listado de seguimientos"></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="image" name="enviar2" src="images/b_insert.png" alt="Modificar la visita" onClick="return confirm('Estás seguro que guardar estos cambios?');">
				</td>
			</tr>
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
