<?

require("conn.php");
require("func.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}

?>
<html>

<head>
<title>Imprimir Factura</title>
<link href="estilo_print.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript">
	function prompter() {
		var reply = prompt("Ingresar el numero del Remito", "")
		factura.remito.value = reply;
	}
</script>

</head>

<?

$id_venta = $_REQUEST['id_venta'];
$sql = "SELECT * FROM ventas v INNER JOIN vendedores ve ON v.id_vendedor = ve.id_vendedor INNER JOIN clientes c ON c.id_cliente = v.id_cliente where id_venta = $id_venta";
$q = query($sql);
$rs = mysql_fetch_array($q);


$fecha = $rs['fecha'];
	list($ano, $mes, $dia) = split( '[/.-]', $fecha);
	$fecha = $dia."/".$mes."/".$ano;

//$factura = $rs['factura'];
$factura = $_REQUEST['factura'];
if($factura == 0 || $factura == "") $factura = 2;

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


if($factura != 0){
?>
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="prompter()">
<?
}else{
?>
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
}

if($factura == 0){
?>
<form name="formu" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<table>
	  <tr height="60"><td colspan="3">&nbsp;</td></tr>
	  <tr class="data">
		<td width="100">&nbsp;</td>
		<td>Tipo de Factura</td>
		<td>
			<select name="factura" onChange="formu.submit();">
			  <option value="0">Selecionar</option>
			  <option value="1">Factura A</option>
			  <option value="2">Factura B</option>
			</select>
			<input type="hidden" name="id_venta" value="<?= $id_venta?>">
		</td>
  	  </tr>
	</table>
</form>
<?
}
else{
?>
<form name="factura" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<?
	if($factura == 1){ // FACTURA A
?>
<table width="710" height="1112" border="0" cellpadding="0" cellspacing="0" align="center"><tr><td>

<table id="Table_01" width="721" height="1049" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td background="images_factura/factura-a_01.jpg" width="6" height="1" alt=""></td>
		<td colspan="12" rowspan="2" background="images_factura/factura-a_02.jpg" width="706" height="14" alt=""></td>
		<td colspan="2" background="images_factura/factura-a_03.jpg" width="8" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="1" height="1" alt=""></td>
	</tr>
	<tr>
		<td rowspan="13" background="images_factura/factura-a_04.jpg" width="6" height="1047" alt=""></td>
		<td rowspan="13" background="images_factura/factura-a_05.jpg" width="1" height="1047" alt=""></td>
		<td rowspan="13" background="images_factura/factura-a_06.jpg" width="7" height="1047" alt=""></td>
		<td background="images_factura/spacer.gif" width="1" height="13" alt=""></td>
	</tr>
	<tr>
		<td colspan="3" background="images_factura/factura-a_07.jpg" width="332" height="36" alt=""></td>
		<td colspan="3" background="images_factura/factura-a_08.jpg" width="43" height="36" alt=""></td>
		<td rowspan="2" background="images_factura/factura-a_09.jpg" width="39" height="37" alt=""></td>
		<td colspan="5" rowspan="3" width="292" height="126" alt="">
			<table width="100%" height="60" border="0" cellpadding="0" cellspacing="0">
			  <tr><td colspan="2">&nbsp;</td></tr>
			  <tr><td width="15">&nbsp;</td><td width="253">&nbsp;</td></tr>
			  <tr><td>&nbsp;</td><td class="txt_f_g">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $fecha?></td></tr>
		  </table>
		</td>
		<td background="images_factura/spacer.gif" width="1" height="36" alt=""></td>
	</tr>
	<tr>
		<td colspan="6" rowspan="2" background="images_factura/factura-a_11.jpg" width="375" height="90" alt=""></td>
		<td background="images_factura/spacer.gif" width="1" height="1" alt=""></td>
	</tr>
	<tr>
		<td background="images_factura/factura-a_12.jpg" width="39" height="89" alt=""></td>
		<td background="images_factura/spacer.gif" width="1" height="89" alt=""></td>
	</tr>
	<tr>
		<td colspan="12" background="images_factura/factura-a_13.jpg" width="706" height="62" alt=""></td>
		<td background="images_factura/spacer.gif" width="1" height="62" alt=""></td>
	</tr>
	<tr valign="top">
		<td colspan="12" width="706" height="60" alt="">
			<table width="97%" height="43"  border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr height="27">
				<td class="tit_f_g">&nbsp;</td>
				<td class="txt_f_g" colspan="3">&nbsp;<?= $nombre?></td>
			  </tr>
			  <tr>
				<td width="10%" class="tit_f_g">&nbsp;</td>
				<td width="53%" class="txt_f_g">&nbsp;<?= $direccion?></td>
				<td width="2%" class="tit_f_g">&nbsp;</td>
				<td width="35%" class="txt_f_g">&nbsp;<?= $tel?></td>
			  </tr>
		  </table>			
		</td>
		<td background="images_factura/spacer.gif" width="1" height="60" alt=""></td>
	</tr>
	<tr>
		<td colspan="12" background="images_factura/factura-a_15.jpg" width="706" height="10" alt=""></td>
		<td background="images_factura/spacer.gif" width="1" height="10" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" background="images_factura/factura-a_16.jpg" width="347" height="76" alt="">
			<table width="98%" border="0" align="center" cellpadding="0" cellspacing="2">
			  <tr>
				<td width="35%" class="tit_f_c">&nbsp;</td>
				<td width="16%" class="txt_f_c">&nbsp;</td>
				<td width="12%">&nbsp;</td>
				<td width="27%">&nbsp;</td>
				<td width="15%">&nbsp;</td>
			  </tr>
			  <tr>
				<td class="tit_f_c">&nbsp;</td>
				<td class="txt_f_c">&nbsp;</td>
				<td>&nbsp;</td>
				<td class="txt_f_c">&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
		  </table>
		</td>
		<td background="images_factura/factura-a_17.jpg" width="12" height="76" alt=""></td>
		<td colspan="7" width="347" height="76" alt="">
			<table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2">
			  <tr>
				<td width="30%" class="tit_f_c">&nbsp;</td>
				<td width="70%" class="txt_f_c">&nbsp;&nbsp;<?= $cuit?></td>
			  </tr>
			  <tr>
				<td class="tit_f_c">&nbsp;</td>
				<td class="txt_f_c"><input class="txt_f" name="remito" value="" readonly="true"  style="border: 1px solid #FFFFFF; padding-left: 4; padding-right: 4; padding-top: 1"></td>
			  </tr>
			  <tr>
				<td class="tit_f_c">&nbsp;</td>
				<td class="txt_f">&nbsp;&nbsp;<?= $remito?></td>
			  </tr>
			</table>
		</td>
		<td background="images_factura/spacer.gif" width="1" height="76" alt=""></td>
	</tr>
	<tr>
		<td colspan="12" background="images_factura/factura-a_19.jpg" width="706" height="31" alt=""></td>
		<td background="images_factura/spacer.gif" width="1" height="31" alt=""></td>
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
	
	$dto_fijo = $rs2['dto_fijo'];
	$dto_porc = $rs2['dto_porc'];
	
	$c = $rs2['cant'];
	$p = $rs2['precio'];
	if($factura == 1) $p = $p / 1.21;
	$r = $rs2['regalo'];
	if($r > 0) $p = 0;
	
	$cant = $cant."<br><br>".$c;
	if($p > 0) $sr = number_format(round($p,2), 2, '.', ',');
	if($p == 0) $sr = "";
	$precio = $precio."<br><br>".$sr;
	$detalle = $detalle."<br><br>".$producto;
	if($p > 0) $tr = number_format($c * round($p,2), 2, '.', ',');
	if($p == 0) $tr = "Bonificado";
	$precio_T = $precio_T."<br><br>". $tr;
	$sub_T += $c * round($p,2); 
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
		$dto = round($dto_porc/100 * $subtotal,2);
		$precio_T = $precio_T."<br><br>( ". number_format(round($dto,2), 2, '.', ',')." )";
	}
}

// ---------------------------

$subtotal = $sub_T;
$iva_T = round($subtotal* ($iva-1),2);
$total = $subtotal + $iva_T;
$total = round( ((100 - $dto_porc) / 100 * $total - $dto_fijo) * 100) / 100;

$otros = "&nbsp;";
$impuestos = "&nbsp;";
?>
	<tr valign="top">
		<td align="center" class="txt_f">
			<table width="30%" align="center"><tr><td class="txt_f" align="center"><?= $cant?></td></tr></table>
		</td>
		<td background="images_factura/factura-a_21.jpg" width="10" height="499" alt=""></td>
		<td colspan="6" background="images_factura/factura-a_22.jpg" width="395" height="499" alt="">
			<table width="95%" align="center"><tr><td align="left" class="txt_f"><?= $detalle?></td></tr></table>
		</td>
		<td background="images_factura/factura-a_23.jpg" width="12" height="499" alt=""></td>
		<td align="center" class="txt_f">
			<table width="30%"><tr><td align="right" class="txt_f"><?= $precio?></td></tr></table>
		</td>
		<td background="images_factura/factura-a_25.jpg" width="11" height="499" alt=""></td>
		<td align="center" class="txt_f">
			<table width="30%"><tr><td align="right" class="txt_f"><?= $precio_T?></td></tr></table>
		</td>
		<td background="images_factura/spacer.gif" width="1" height="499" alt=""></td>
	</tr>
	<tr>
		<td colspan="12" background="images_factura/factura-a_27.jpg" width="706" height="16" alt=""></td>
		<td background="images_factura/spacer.gif" width="1" height="16" alt=""></td>
	</tr>
	<tr>
		<td colspan="11" background="images_factura/factura-a_28.jpg" width="595" height="111" alt=""></td>
		<td width="111" height="111" alt="">
			<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			  <tr valign="top"><td align="right" class="txt_f">$&nbsp;<?= number_format($subtotal,2,'.',',')?></td></tr>
			  <tr valign="top"><td align="right" class="txt_f"><?= $impuestos?></td></tr>
			  <tr valign="top"><td align="right" class="txt_f">$&nbsp;<?= $iva_T?></td></tr>
			  <tr valign="top"><td align="right" class="txt_f"><?= $otros?></td></tr>
			  <tr valign="top"><td align="right" class="txt_f">$&nbsp;<?= number_format($total,2,'.',',')?></td></tr>
			</table>
		</td>
		<td background="images_factura/spacer.gif" width="1" height="111" alt=""></td>
	</tr>
	<tr>
		<td colspan="12" background="images_factura/factura-a_30.jpg" width="706" height="43" alt=""></td>
		<td background="images_factura/spacer.gif" width="1" height="43" alt=""></td>
	</tr>
	<tr>
		<td background="images_factura/spacer.gif" width="6" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="57" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="10" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="265" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="15" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="12" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="16" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="39" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="48" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="12" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="110" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="11" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="111" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="1" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="7" height="1" alt=""></td>
		<td></td>
	</tr>
</table>

</td></tr></table>
<? 
	}
	if($factura != 1){ // FACTURA B
?>
<table width="720" height="1110" border="0" cellpadding="0" cellspacing="0" align="center"><tr><td>

<table id="Table_01" width="720" height="1049" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td rowspan="12" background="images_factura/factura-b_01.jpg" width="4" height="1048" alt=""></td>
		<td colspan="12" background="images_factura/factura-b_02.jpg" width="709" height="14" alt=""></td>
		<td rowspan="12" background="images_factura/factura-b_03.jpg" width="7" height="1048" alt=""></td>
	</tr>
	<tr>
		<td colspan="3" background="images_factura/factura-b_04.jpg" width="335" height="36" alt=""></td>
		<td colspan="3" background="images_factura/factura-b_05.jpg" width="40" height="36" alt=""></td>
		<td background="images_factura/factura-b_06.jpg" width="34" height="36" alt=""></td>
		<td colspan="5" rowspan="2" width="300" height="124" alt="">
			<table width="100%" height="82" border="0" cellpadding="0" cellspacing="0">
			  <tr><td colspan="2">&nbsp;</td></tr>
			  <tr><td width="15">&nbsp;</td><td width="253">&nbsp;</td></tr>
			  <tr><td>&nbsp;</td><td class="txt_f_g">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $fecha?></td></tr>
		  </table>
		</td>
	</tr>
	<tr>
		<td colspan="7" background="images_factura/factura-b_08.jpg" width="409" height="88" alt=""></td>
	</tr>
	<tr>
		<td colspan="12" background="images_factura/factura-b_09.jpg" width="709" height="61" alt=""></td>
	</tr>
	<tr>
		<td colspan="12" width="709" height="61" alt="">
			<table width="97%" height="43"  border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td class="tit_f_g">&nbsp;</td>
				<td class="txt_f_g" colspan="3">&nbsp;<?= $nombre?></td>
			  </tr>
			  <tr>
				<td width="10%" class="tit_f_g">&nbsp;</td>
				<td width="53%" class="txt_f_g">&nbsp;<?= $direccion?></td>
				<td width="2%" class="tit_f_g">&nbsp;</td>
				<td width="35%" class="txt_f_g">&nbsp;<?= $tel?></td>
			  </tr>
		  </table>		
		</td>
	</tr>
	<tr>
		<td colspan="12" background="images_factura/factura-b_11.jpg" width="709" height="13" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" width="348" height="55" alt="">
			<table width="98%" border="0" align="center" cellpadding="0" cellspacing="2">
			  <tr>
				<td width="6%" class="tit_f_c">&nbsp;</td>
				<td width="19%" class="txt_f_c"><div align="right">&nbsp;</div></td>
				<td width="13%" class="txt_f_c">&nbsp;</td>
				<td width="19%" class="txt_f_c"><div align="right">&nbsp;</div></td>
				<td width="7%">&nbsp;</td>
				<td width="9%" class="txt_f_c"><div align="right">&nbsp;</div></td>
				<td width="7%" class="txt_f_c">&nbsp;</td>
				<td width="13%" class="txt_f_c"><div align="right">&nbsp;</div></td>
				<td width="7%">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="3" class="tit_f_c">&nbsp;</td>
				<td class="txt_f_c"><div align="right">&nbsp;</div></td>
				<td>&nbsp;</td>
				<td colspan="3" class="txt_f_c"><div align="right">&nbsp;</div></td>
				<td>&nbsp;</td>
			  </tr>
		  </table>
		</td>
		<td background="images_factura/factura-b_13.jpg" width="14" height="55" alt=""></td>
		<td colspan="7" width="347" height="55" alt="">
			<table width="98%" border="0" align="center" cellpadding="2" cellspacing="2">
			  <tr valign="bottom" height="25">
				<td width="20%" class="tit_f_c">&nbsp;</td>
				<td width="80%" class="txt_f_c">&nbsp;&nbsp;<?= $cuit?></td>
			  </tr>
			  <tr>
				<td class="tit_f_c" height="20">&nbsp;</td>
				<td class="txt_f_c" valign="baseline"><input name="remito" value="" readonly="true"  style="border: 1px solid #FFFFFF; padding-left: 4; padding-right: 4; padding-top: 1" class="txt_f_c"></td>
			  </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="12" background="images_factura/factura-b_15.jpg" width="709" height="31" alt=""></td>
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
	$producto = $linea. " - ".$rs2['variedad']. " - ".$rs2['presentacion'].$det;
	
	$c = $rs2['cant'];
	$p = $rs2['precio'];
	$r = $rs2['regalo'];
	if($r > 0) $p = 0;
	
	$cant = $cant."<br><br>".$c;
	if($p > 0) $sr = number_format($p,2,'.',',');
	if($p == 0) $sr = "";
	$precio = $precio."<br><br>".$sr;
	$detalle = $detalle."<br><br>".$producto;
	if($p > 0) $tr = number_format($c * $p,2,'.',',');
	if($p == 0) $tr = "Bonificado";
	$precio_T = $precio_T."<br><br>". $tr;
	
	$subtotal += $c * $p; 
	$total += $subtotal;
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
		$dto = round($dto_porc/100 * $subtotal,2);
		$precio_T = $precio_T."<br><br>( ". number_format(round($dto,2), 2, '.', ',')." )";
	}
}

// ---------------------------
$total = round( ((100 - $dto_porc) / 100 * $subtotal - $dto_fijo) * 100) / 100;

?>
	<tr valign="top">
		<td align="center" class="txt_f">
			<table width="30%" align="center"><tr><td class="txt_f" align="center"><?= $cant?></td></tr></table>
		</td>
		<td background="images_factura/factura-b_17.jpg" width="16" height="589" alt=""></td>
		<td colspan="6" background="images_factura/factura-b_18.jpg" width="393" height="589" alt="" class="txt_f">
			<table width="95%" align="center"><tr><td align="left" class="txt_f"><?= $detalle?></td></tr></table>
		</td>
		<td background="images_factura/factura-b_19.jpg" width="13" height="589" alt=""></td>
		<td align="center">
			<table width="30%"><tr><td align="right" class="txt_f"><?= $precio?></td></tr></table>
		</td>
		<td background="images_factura/factura-b_21.jpg" width="13" height="589" alt=""></td>
		<td align="center">
			<table width="30%"><tr><td align="right" class="txt_f"><?= $precio_T?></td></tr></table>
		</td>
	</tr>
	<tr>
		<td colspan="12" background="images_factura/factura-b_23.jpg" width="709" height="11" alt=""></td>
	</tr>
	<tr>
		<td colspan="11" background="images_factura/factura-b_24.jpg" width="597" height="48" alt=""></td>
		<td width="112" height="48" alt="">
			<table width="95%" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr valign="bottom"><td align="center" class="txt_f_g"><?= number_format($total,2,'.',',')?></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="12" background="images_factura/factura-b_26.jpg" width="709" height="41" alt=""></td>
	</tr>
	<tr>
		<td background="images_factura/spacer.gif" width="4" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="56" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="16" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="263" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="13" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="14" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="13" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="34" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="56" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="13" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="106" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="13" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="112" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="7" height="1" alt=""></td>
	</tr>
</table>

</td></tr></table>

<?
	}
?>

</form>
<?
} // cierra el if que chequea que halla elegido una factura
?>
</body>
</html>