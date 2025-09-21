<?

require("conn.php");
require("func.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}

$factura = $_REQUEST['factura'];
?>
<html>

<head>
<title>Imprimir Factura</title>
<link href="estilo_print.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<?

$id_venta = $_REQUEST['id_venta'];
$sql = "SELECT * FROM ventas v 
		INNER JOIN vendedores ve ON v.id_vendedor = ve.id_vendedor 
		INNER JOIN clientes c ON c.id_cliente = v.id_cliente where id_venta = $id_venta";
$q = query($sql);
$rs = mysql_fetch_array($q);

// Le agrego ceros al nro de NP
	$id_v = $rs['id_venta'];
	$largo = strlen($id_venta);
	$ceros = 8 - $largo;
	for($i = 0; $i < $ceros; $i++){
		$num = $num."0"; 
	}
	$nro_NP = $num."".$id_v;
// -----------------

$fecha = $rs['fecha'];
	list($ano, $mes, $dia) = split( '[/.-]', $fecha);
	$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$mes = $mes - 1;
	$fecha = $dia." de ".$meses[$mes]." de ".$ano;

$tipo = "NP";

$remito = $rs['remito'];
$nombre = $rs['apellido'];
$n = $rs['nombre'];
if($n != "") $nombre = $nombre.", ".$n;
$mail = $rs['mail'];

$telefono = $rs['telefono'];
$celular = $rs['celular'];
if($telefono != "" && $celular != "") $b = " - ";
if($telefono == "" && $celular != "") $b = "";
$tel = " ".$telefono." ".$b." ".$celular; 

if($rs['cp'] != 0) $cp = "(".$rs['cp'].")";
$direccion = $rs['direccion']." ".$cp." ".$rs['localidad'];
if($direccion != "") $direccion = $direccion;

$cuit = $rs['cuit'];

$dto_porc = $rs['dto_porc'];
$dto_fijo = $rs['dto_fijo'];

$observaciones = $rs['texto'];	
$tipo_visita = $rs['tipo_visita'];
if($tipo_visita == 0) $titulo = "VENTA";
if($tipo_visita == 1) $titulo = "VENTA";
if($tipo_visita == 2) $titulo = "VISITA";

$forma = "factura";
?>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


<? if($forma == "remito"){?>
<table id="Table_01" width="650" height="947" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td rowspan="12"><img src="images_factura/acordes-r_01.jpg" width="3" height="946" alt=""></td>
		<td colspan="9"><img src="images_factura/acordes-r_02.jpg" width="640" height="13" alt=""></td>
		<td rowspan="12"><img src="images_factura/acordes-r_03.jpg" width="7" height="946" alt=""></td>
	</tr>
	<tr>
		<td colspan="3"><img src="images_factura/acordes-r_04.jpg" width="301" height="34" alt=""></td>
		<td colspan="3" align="center" class="factura"><?= $tipo?></td>
		<td><img src="images_factura/acordes-r_06.jpg" width="30" height="34" alt=""></td>
		<td colspan="2" rowspan="2">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr><td colspan="2" class="tit_f_c">DOCUMENTO NO VALIDO COMO FACTURA</td></tr>
			  <tr><td>&nbsp;</td></tr>
			  <tr><td width="15">&nbsp;</td><td width="253" class="tit_f_g">&nbsp;</td></tr>
			  <tr><td>&nbsp;</td><td class="tit_f_g">Fecha: <?= $fecha?></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="7"><img src="images_factura/acordes-r_08.jpg" width="372" height="79" alt=""></td>
	</tr>
	<tr>
		<td colspan="7"><img src="images_factura/acordes-r_09.jpg" width="372" height="56" alt=""></td>
		<td colspan="2"><img src="images_factura/acordes-r_10.jpg" width="268" height="56" alt=""></td>
	</tr>
	<tr height="57">
		<td colspan="9">
			<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td class="tit_f_g">Se&ntilde;or/es: </td>
				<td class="txt_f_g" colspan="3">&nbsp;<?= $nombre?></td>
			  </tr>
			  <tr>
				<td width="10%" class="tit_f_g">Direccion:</td>
				<td width="53%" class="txt_f_g">&nbsp;<?= $direccion?></td>
				<td width="2%" class="tit_f_g">Tel:</td>
				<td width="35%" class="txt_f_g">&nbsp;<?= $tel?></td>
			  </tr>
			</table>		
		</td>
	</tr>
	<tr>
		<td colspan="9"><img src="images_factura/acordes-r_12.jpg" width="640" height="7" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<table width="98%" border="0" align="center" cellpadding="0" cellspacing="2">
			  <tr>
				<td width="13%" class="tit_f_c">Iva:</td>
				<td colspan="5" class="tit_f_c">____________________________________________________</td>
			  </tr>
			  <tr>
				<td colspan="2" class="tit_f_c">Condiciones de Venta</td>
				<td width="16%" class="txt_f_c">Contado</td>
				<td width="11%"><input type="checkbox" name="e" value="1"></td>
				<td width="26%" class="txt_f_c">Cuenta Corriente</td>
				<td width="14%"><input type="checkbox" name="e" value="1"></td>
			  </tr>
			  <tr><td width="13%" class="tit_f_c" colspan="6">&nbsp;</td></tr>
			  <tr><td width="13%" class="tit_f_c" colspan="6">REMITIMOS A UD. LO SIGUIENTE:</td></tr>
		  </table>
		</td>
		<td><img src="images_factura/acordes-r_14.jpg" width="12" height="78" alt=""></td>
		<td colspan="4">
			<table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2">
			  <tr>
				<td width="25%" class="tit_f_c">CUIT N°:</td>
				<td width="75%" class="txt_f_c"><?= $cuit?></td>
			  </tr>
			  <tr>
				<td class="tit_f_c">Remito N°</td>
				<td class="txt_f_c">&nbsp;</td>
			  </tr>
			  <tr>
				<td class="tit_f_c">O. Compra N°:</td>
				<td class="txt_f_c"><?= $remito?></td>
			  </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="9"><img src="images_factura/acordes-r_16.jpg" width="640" height="27" alt=""></td>
	</tr>
<?
$q2 = query("SELECT * FROM ventas v 
			INNER JOIN ventas_detalle vd ON vd.id_venta = v.id_venta 
			INNER JOIN productos p ON p.id_producto = vd.id_producto
			INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria 
			INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea 
			INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
			INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
			WHERE v.id_venta = $id_venta ORDER BY pc.orden, p.orden");
while($rs2 = mysql_fetch_array($q2)){
	$categoria = $rs2['categoria'];
	$linea = $rs2['linea'];
	$id_producto = $rs2['id_producto'];
	if($rs2['volumen'] != "") $vol = " x ".$rs2['volumen']." ml.";
	$det = " (".$rs2['unidades']."".$vol.")";
	$producto = $rs2['variedad']. " - ".$rs2['presentacion'].$det;
	
	$c = $rs2['cant'];
	$cant = $cant."<br>".$c;
	$detalle = $detalle."<br>&nbsp;&nbsp;".$producto;
	$total += $c;
}

?>
	<tr height="436" valign="top">
		<td class="txt_f" align="center"><?= $cant?></td>
		<td><img src="images_factura/acordes-r_18.jpg" width="7" height="436" alt=""></td>
		<td colspan="7" background="images_factura/acordes-r_19.jpg" width="578" height="436" alt="" class="txt_f"><?= $detalle?></td>
	</tr>
	<tr>
		<td colspan="9"><img src="images_factura/acordes-r_20.jpg" width="640" height="11" alt=""></td>
	</tr>
	<tr>
		<td colspan="8"><img src="images_factura/acordes-r_21.jpg" width="540" height="25" alt=""></td>
		<td align="center" class="txt_f"><?= $total?>&nbsp;cajas</td>
	</tr>
	<tr>
		<td colspan="9"><img src="images_factura/acordes-r_23.jpg" width="640" height="123" alt=""></td>
	</tr>
	<tr>
		<td><img src="images_factura/spacer.gif" width="3" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="55" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="7" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="239" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="14" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="12" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="15" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="30" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="168" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="100" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="7" height="1" alt=""></td>
	</tr>
</table>

<?
}  // CIERRO REMITO
if($forma == "factura"){
?>

<table id="Table_01" width="650" height="947" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td rowspan="12"><img src="images_factura/factura-np_01.jpg" width="4" height="100%" alt=""></td>
		<td colspan="12"><img src="images_factura/factura-np_02.jpg" width="639" height="13" alt=""></td>
		<td rowspan="12"><img src="images_factura/factura-np_03.jpg" width="7" height="946" alt=""></td>
	</tr>
	<tr>
		<td colspan="3"><img src="images_factura/factura-np_04.jpg" width="303" height="33" alt=""></td>
		<td colspan="3" align="center" class="factura"><?= $tipo?></td>
		<td><img src="images_factura/factura-np_06.jpg" width="31" height="33" alt=""></td>
		<td colspan="5" rowspan="2">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr><td colspan="2" class="tit_f_c">DOCUMENTO NO VALIDO COMO FACTURA</td></tr>
			  <tr><td>&nbsp;</td></tr>
			  <tr><td width="15">&nbsp;</td><td width="253" class="tit_f_g">Nota de Pedido N°: <?= $nro_NP?><br>&nbsp;</td></tr>
			  <tr><td>&nbsp;</td><td class="tit_f_g">Fecha: <?= $fecha?></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="7"><img src="images_factura/factura-np_08.jpg" width="370" height="80" alt=""></td>
	</tr>
	<tr>
		<td colspan="12"><img src="images_factura/factura-np_09.jpg" width="639" height="55" alt=""></td>
	</tr>
	<tr height="54">
		<td colspan="12">
			<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td class="tit_f_g">Se&ntilde;or/es: </td>
				<td class="txt_f_g" colspan="3">&nbsp;<?= $nombre?></td>
			  </tr>
			  <tr>
				<td width="10%" class="tit_f_g">Dirección:</td>
				<td width="53%" class="txt_f_g">&nbsp;<?= $direccion?></td>
				<td width="2%" class="tit_f_g">Tel:</td>
				<td width="35%" class="txt_f_g">&nbsp;<?= $tel?></td>
			  </tr>
			</table>		
		</td>
	</tr>
	<tr>
		<td colspan="12"><img src="images_factura/factura-np_11.jpg" width="639" height="12" alt=""></td>
	</tr>
	<tr height="50">
		<td colspan="4">
			<table width="98%" border="0" align="center" cellpadding="0" cellspacing="2">
			  <tr>
				<td width="6%" class="tit_f_c">Iva:</td>
				<td width="17%" class="txt_f_c"><div align="right">Cons. final</div></td>
				<td width="14%" class="txt_f_c"><input type="checkbox" name="ri2" value="1"></td>
				<td width="14%" class="txt_f_c"><div align="right">Monot.</div></td>
				<td width="7%"><input type="checkbox" name="ri" value="1"></td>
				<td width="12%" class="txt_f_c"><div align="right">Exento</div></td>
				<td width="7%" class="txt_f_c"><input type="checkbox" name="ri3" value="1"></td>
				<td width="16%" class="txt_f_c"><div align="right">No resp. </div></td>
				<td width="7%"><input type="checkbox" name="ri4" value="1"></td>
			  </tr>
			  <tr>
				<td colspan="3" class="tit_f_c">Condiciones de Venta</td>
				<td class="txt_f_c"><div align="right">Contado</div></td>
				<td><input type="checkbox" name="e" value="1"></td>
				<td colspan="3" class="txt_f_c"><div align="right">Cuenta Corriente</div></td>
				<td><input type="checkbox" name="e" value="1"></td>
			  </tr>
		  </table>
		</td>
		<td><img src="images_factura/factura-np_13.jpg" width="12" height="50" alt=""></td>
		<td colspan="7" height="50">
			<table width="98%" border="0" align="center" cellpadding="2" cellspacing="2">
			  <tr>
				<td width="25%" class="tit_f_c">CUIT N°:</td>
				<td width="75%" class="txt_f_c"><?= $cuit?></td>
			  </tr>
			  <tr>
				<td class="tit_f_c">Remito N°</td>
				<td class="txt_f_c"><input name="remito" value="" readonly="true"  style="font-weight:bold; border: 1px solid #FFFFFF; padding-left: 4; padding-right: 4; padding-top: 1"></td>
			  </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="12"><img src="images_factura/factura-np_15.jpg" width="639" height="28" alt=""></td>
	</tr>
<?
	$iva = 1.21; // IVA ------------------------------------------------------------

$q2 = query("SELECT * FROM ventas v 
			INNER JOIN ventas_detalle vd ON vd.id_venta = v.id_venta 
			INNER JOIN productos p ON p.id_producto = vd.id_producto
			INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria 
			INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea 
			INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
			INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
			WHERE v.id_venta = $id_venta ORDER BY pc.orden, p.orden");
while($rs2 = mysql_fetch_array($q2)){
	$categoria = $rs2['categoria'];
	$linea = $rs2['linea'];
	$id_producto = $rs2['id_producto'];
	if($rs2['volumen'] != "") $vol = " x ".$rs2['volumen']." ml.";
	$det = " (".$rs2['unidades']."".$vol.")";
	$producto = $linea. " - ".$rs2['variedad']. " - ".$rs2['presentacion'].$det;
	
	$c = $rs2['cant'];
	$p = $rs2['precio'];
	if($factura == 1) $p = $p / 1.21;
	$r = $rs2['regalo'];
	if($r == 1) $p = 0;
	
	if($p == 0 && $pr != 1){	// Si es una promocion lo separo un poco.
		$espacio = "<br>";
		$pr = 1;
	}

	$cant_T += $c;
	$cant = $cant."<br>".$espacio."".$c;

	if($factura != 1){
		if($p > 0) $sr = number_format($p);
		if($p == 0) $sr = "";
		$precio = $precio."<br>".$espacio."".$sr;
		$detalle = $detalle."<br>".$espacio."".$producto;
		if($p > 0) $tr = number_format($c * $p,2,'.',',');
		if($p == 0) $tr = "Bonificado";
		$precio_T = $precio_T."<br>".$espacio."".$tr;
		$subtotal += $c * $p; 
	}
	else{
		if($p > 0) $sr = number_format(round($p,2), 2, '.', ',');
		if($p == 0) $sr = "";
		$precio = $precio."<br>".$espacio."".$sr;
		$detalle = $detalle."<br>".$espacio."".$producto;
		if($p > 0) $tr = number_format($c * round($p,2), 2, '.', ',');
		if($p == 0) $tr = "Bonificado";
		$precio_T = $precio_T."<br>".$espacio."".$tr;
		$subtotal += $c * round($p,2); 
	}
}

// AGREGO EL DETALLE DEL DESCUENTO
//if($dto_porc != 0 || $dto_fijo != 0){
//	if($dto_fijo != 0.00){
//		$detalle = $detalle."<br><br>Descuento fijo";
//		$precio_T = $precio_T."<br><br>( ". number_format(round($dto_fijo,2), 2, '.', ',')." )";
//		$dto = $dto_fijo;
//	}
//	else{
//		$detalle = $detalle."<br><br>Descuento del ". (int)$dto_porc . " %";
//		$dto = round($dto_porc/100 * $subtotal,2);
//		$precio_T = $precio_T."<br><br>( ". number_format(round($dto,2), 2, '.', ',')." )";
//	}
//}

// ---------------------------

//$total = round( ((100 - $dto_porc) / 100 * $subtotal - $dto_fijo) * 100) / 100;
$total = $subtotal;
$cant = $cant."<br><br>_____<br><br>".$cant_T;

if($factura == 1){
	$iva_T = round($total * ($iva-1),2);
	$detalle = $detalle."<br><br>IVA";
	$precio_T = $precio_T."<br><br>". number_format(round($iva_T ,2), 2, '.', ',');
	$total = $total + $iva_T;
}
// AGREGO EL DETALLE DEL DESCUENTO
if($dto_porc != 0 || $dto_fijo != 0){
	if($dto_fijo != 0.00){
		$detalle = $detalle."<br><br>Descuento fijo";
		$precio_T = $precio_T."<br><br>( ". number_format(round($dto_fijo,2), 2, '.', ',')." )";
		$dto = $dto_fijo;
	}
	else{
		$detalle = $detalle."<br><br>Descuento del ". (int)$dto_porc . " %";
		$dto = round($dto_porc/100 * $total,2);
		$precio_T = $precio_T."<br><br>( ". number_format(round($dto,2), 2, '.', ',')." )";
	}
}

// ---------------------------
$total = round( ((100 - $dto_porc) / 100 * $total - $dto_fijo) * 100) / 100;
?>
	<tr valign="top" height="531">
		<td align="center" class="txt_f"><?= $cant?></td>
		<td><img src="images_factura/factura-np_17.jpg" width="14" height="531" alt=""></td>
		<td colspan="6" background="images_factura/factura-np_18.jpg" width="355" height="531" alt="" class="txt_f"><?= $detalle?></td>
		<td><img src="images_factura/factura-np_19.jpg" width="12" height="531" alt=""></td>
		<td align="center">
			<table width="50%" align="center" cellpadding="0" cellspacing="0" border="0"><tr><td align="right" class="txt_f"><?= $precio?></td></tr></table>
		</td>
		<td><img src="images_factura/factura-np_21.jpg" width="12" height="531" alt=""></td>
		<td align="center">
			<table width="50%" align="center" cellpadding="0" cellspacing="0" border="0"><tr><td align="right" class="txt_f"><?= $precio_T?></td></tr></table>
		</td>
	</tr>
	<tr>
		<td colspan="12"><img src="images_factura/factura-np_23.jpg" width="639" height="11" alt=""></td>
	</tr>
	<tr>
		<td colspan="11"><img src="images_factura/factura-np_24.jpg" width="540" height="43" alt=""></td>
		<td>
			<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			  <tr valign="top"><td align="right">$&nbsp;<?= number_format($total,2,'.',',')?></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="12"><img src="images_factura/factura-np_26.jpg" width="639" height="36" alt=""></td>
	</tr>
	<tr>
		<td><img src="images_factura/spacer.gif" width="4" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="51" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="14" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="238" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="12" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="12" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="12" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="31" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="50" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="12" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="96" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="12" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="99" height="1" alt=""></td>
		<td><img src="images_factura/spacer.gif" width="7" height="1" alt=""></td>
	</tr>
</table>
<?
} // CIERRO FACTURA
?>
</body>
</html>