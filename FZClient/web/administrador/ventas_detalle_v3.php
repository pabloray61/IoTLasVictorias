<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

	$iva = 1.21; // IVA ------------------------------------------------------------

$id_cliente = $_REQUEST['id_cliente'];
$id_venta = $_REQUEST['id_venta'];
$id_deposito = $_REQUEST['id_deposito'];

// IMPRIMIR O INSERTAR LAS CONSULTAS -------------------

$insertar = "ok";		//	INSERT
//$imprimir = "ok";		//	PRINT

// ------------------------------------------------------

if ($_REQUEST['guardar'] == "ok"){ // ----------------------- GUARDAR -------------------------------
	$sql1="UPDATE ventas SET dto_fijo=". round($_REQUEST['dto_fijo']*100)/100 . ", dto_porc=". round($_REQUEST['dto_porc']*100)/100 . " WHERE id_venta=" . $_REQUEST['id_venta'];
	
	if($insertar == "ok") query($sql1);
	if($imprimir == "ok") echo($sql1."<br>");

	$i=0;

	$qv = query("SELECT * FROM ventas_detalle WHERE id_venta = ". $_REQUEST['id_venta']);

	// MODIFICO EL STOCK ANTES CARGADO
	$i = 0;
	while($rsbc = mysql_fetch_array($qv)){
		$q = query("SELECT * FROM stock WHERE id_producto = ". $rsbc['id_producto'] . " && id_deposito = ".$_REQUEST["id_deposito"]);
		$rs = mysql_fetch_array($q);
		$c = $rs['cantidad'];
		if($c > 0){		
			$c_s = $c + $rsbc['cant'];
			$sqls = "UPDATE stock SET cantidad = $c_s where id_producto = ". $rsbc['id_producto'] . " && id_deposito = ".$_REQUEST["id_deposito"];
			if($insertar == "ok") mysql_query($sqls, $conn_id);
			if($imprimir == "ok") echo($sqls."<br>");
		}
		else{
			$sqls = "INSERT INTO stock VALUES (NULL, ".$_REQUEST["id_deposito"].",".$rsbc['id_producto'].", ".$_REQUEST['c_p'.$i].")";
			if($insertar == "ok") mysql_query($sqls, $conn_id);
			if($imprimir == "ok") echo($sqls."<br>");
		}
		$i++;
	}
	//BORRO LO QUE ESTE CARGADO EN VENTAS DETALLE -----------------------------------

	$sql = "DELETE FROM ventas_detalle WHERE id_venta=". $_REQUEST['id_venta'];
	if($imprimir == "ok") echo $sql . "<br>";
	if($insertar == "ok") query($sql);
	
	// INSERTO NUEVAMENTE LOS VALORES NUEVOS ----------------------------------------------------------
	$i=0;
	while($_REQUEST['id_producto' . $i] > 0){
		if($_REQUEST['c'.$i] != 0){	
			$cant_prod = $_REQUEST['cant'];
			$precio = $_REQUEST['p'.$i];
			$dto_fijo = round($_REQUEST['dto_fijo']*100)/100;
			$dto_porc = round($_REQUEST['dto_porc']*100)/100;
			$dto1 = 0;
			$dto2 = 0;
			if($dto_fijo > 0) $dto1 = $dto_fijo / $cant_prod;
			if($dto_porc > 0) $dto2 = $precio * $dto_porc / 100;
			$precio_final = $precio - $dto1 - $dto2;

			$regalo = $_REQUEST['r'.$i];
			if($regalo == "") $regalo = 0;
			
			$sql= "INSERT INTO ventas_detalle VALUES (NULL, ".$_REQUEST['id_venta']." , ". $_REQUEST['id_producto'.$i] . "," . round($_REQUEST['c'.$i]) . "," . $precio . "," . $precio_final . "," . $regalo . ")";
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
		}
	$i++;
	}
} // --------------------------------------------------------------------------------------------------------------------------------------
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
			to = (total*(1-form2.dto_porc.value/100)-form2.dto_fijo.value) + iva;
			form2.total.value = to.toFixed(2);
		}else{
			form2.cant.value = cant;
			to = (total*(1-form2.dto_porc.value/100)-form2.dto_fijo.value);
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
$sql = query("SELECT * FROM clientes WHERE id_cliente= ". $id_cliente);
$rs = mysql_fetch_array($sql);

$nombre = $rs['nombre']." ".$rs['apellido'];
$direccion = $rs['direccion'];
$cuit = $rs['cuit'];
$localidad = $rs['localidad'];
$mail = $rs['mail'];
$telefono = $rs['telefono'];
$id_cliente = $rs['id_cliente'];

$qv = query("SELECT * FROM ventas WHERE id_venta = $id_venta");
$rsv = mysql_fetch_array($qv);
$factura = $rsv['factura'];

?>

<table width="800" align="center" cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td width="5%">&nbsp;</td>
		<td width="30%" class="encabezado">AGENTE: <?=$_SESSION['nombre_vend']?></td>
		<td width="60%" align="right"></td>
		<td width="5%">&nbsp;</td>
	</tr>
	<tr><td colspan="4"></td></tr>
	<tr height="30"><td class="t" colspan="4" align="center">Detalle de la venta</td></tr>

		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">Cliente:&nbsp;&nbsp;<?= $nombre?></td>
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
						<td class="data">
							<? if($factura == 1){echo "Factura A";}?>
							<? if($factura == 2){echo "Factura B";}?>
							<? if($factura == 3){echo "Factura C";}?>
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
		<?
		
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
		?>
		<tr>
			<td class="c1">&nbsp;</td>
			<td class="c1" colspan="2">
				<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr><td colspan="4">&nbsp;</td></tr>
					<tr height="25">
						<td class="dataBold">N&deg; de orden :</td>
						<td class="data"><?=$remito?></td>
						<td class="dataBold">Fecha:</td>
						<td class="data"><?= $fecha?></td>
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
					<tr><td colspan="4">&nbsp;</td></tr>
				</table>
			</td>
			<td class="c1">&nbsp;</td>
		</tr>
		<?
		if($id_deposito != ""){
			$q_deposito = query("SELECT * FROM depositos WHERE id_deposito = $id_deposito");
			$rs_q = mysql_fetch_array($q_deposito);
			?>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2" colspan="2">
					<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
						<tr>
							<td width="12%" class="dataBold">Deposito:</td>
							<td width="88%" class="data"><?=$rs_q['deposito']?></td></tr>
					</table>
				</td>
				<td class="c2">&nbsp;</td>
			</tr>
		<? }?>
	<tr height="15"><td colspan="4" class="t"></td></tr>
</table>

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
						$cantidad = "";
						$precio = "";
						$q2 = query("SELECT * FROM ventas_detalle WHERE id_venta = $id_venta and id_producto = $id_producto");
						$rs2 = mysql_fetch_array($q2);
						$cant = $rs2['cant'];
						$precio = $rs2['precio'];
						$regalo = $rs2['regalo'];
						if($regalo > 0) $precio = 0;
						$sub = $cant * $precio;
						
						if($cantidad == "") $cantidad = $rs_p['cantidad'];
						if($precio == "") $precio = $rs_p['precio'];
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
							<td class="<?= $c?>" align="center"><input name="r<?= $i?>" value="1"  type="checkbox" class="r" onclick="setReadOnly(<?= $i?>);" <?= $regalo > 0 ? "checked" : ""?>></td>
							<td class="<?= $c?>">&nbsp;</td>
						</tr>
					<? 
						$sub_T += $sub;
						$total_cant += $cant;
						$total += $sub;
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
						<td class="c2" align="center"><input name="iva_T" type="text" size="5" value="<?= number_format(round($iva_T,2),2,',', '.')?>"  onChange="actualizar<?= $na?>();"></td>
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
				<tr height="35">
					<td class="t">&nbsp;</td>
					<td class="t" colspan="2">Total</td>
					<td class="t" align="center">&nbsp;</td>
					<td class="t" align="center"><input type="text" name="cant" value="<?=$total_cant?>" size="3" readonly="true"></td>
					<td class="t" align="center"><input type="text" name="total" size="6" value="<?=number_format(round($total,2),2,',', '.')?>" readonly="true"></td>
					<td class="t">&nbsp;</td>
					<td class="t">&nbsp;</td>
				</tr>
			<? }?>
			<? if($observaciones != ""){?>
				<tr height="40"><td colspan="8"></td></tr>
				<tr height="30"><td class="t">&nbsp;</td><td colspan="6" class="t">Observaciones</td></tr>
				<tr height="110">
					<td class="c1">&nbsp;</td>
					<td class="c1" colspan="6" class="txt"><?= $observaciones?></td>
					<td class="c1">&nbsp;</td>
				</tr>
				<tr height="15"><td colspan="8" class="t"></td></tr>
			<? }?>
			<tr height="40"><td colspan="8"></td></tr>
			<tr height="40">
				<td colspan="8" align="center">
					<input type="hidden" name="guardar" value="ok">
					<input type="image" name="enviar3" src="images/b_insert.png" alt="Modificar la venta" onClick="return confirm('Estás seguro que queres modificar esta venta?');">&nbsp;&nbsp;
					<a href="abm_ventas_cliente.php?id_cliente=<?= $id_cliente?>"><img src="images/b_back.png" border="0"></a>
				</td>
			</tr>
		</table>
</form>

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
