<?

require("conn.php");
require("func.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}

?>
<html>

<head>
<title>Imprimir Remito</title>
<link href="estilo_print.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?

$id_venta = $_REQUEST['id_venta'];
$sql = "SELECT * FROM ventas v INNER JOIN vendedores ve ON v.id_vendedor = ve.id_vendedor INNER JOIN clientes c ON c.id_cliente = v.id_cliente where id_venta = $id_venta";
$q = query($sql);
$rs = mysql_fetch_array($q);

// Le agrego ceros al nro de factura
	$id_venta = $rs['id_venta'];
	$largo = strlen($id_venta);
	$ceros = 8 - $largo;
	for($i = 0; $i < $ceros; $i++){
		$num = $num."0"; 
	}
	//$nro_factura = $num."".$id_venta;
// -----------------

$fecha = $rs['fecha'];
	list($ano, $mes, $dia) = split( '[/.-]', $fecha);
	$fecha = $dia."/".$mes."/".$ano;

$factura = $rs['factura'];
if($factura == 0) $factura = $_REQUEST['factura'];

	if($factura == 1) $tipo = "A";
	if($factura == 2) $tipo = "B";
	if($factura == 3) $tipo = "R";

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
?>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="720" height="1082" border="0" cellpadding="0" cellspacing="0" align="center"><tr><td>&nbsp;

<table id="Table_01" width="720" height="1049" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td rowspan="14" background="images_factura/factura-r_01.jpg" width="8" height="1048" alt=""></td>
		<td colspan="6" background="images_factura/factura-r_02.jpg" width="704" height="8" alt=""></td>
		<td rowspan="14" background="images_factura/factura-r_03.jpg" width="8" height="1048" alt=""></td>
	</tr>
	<tr>
		<td colspan="6" background="images_factura/factura-r_04.jpg" width="704" height="69" alt=""></td>
	</tr>
	<tr valign="top">
		<td colspan="4" background="images_factura/factura-r_05.jpg" width="473" height="59" alt=""></td>
		<td colspan="2" width="231" alt="">
			<table width="100%" height="52" border="0" cellspacing="0" cellpadding="0">
			  <tr><td width="100%" class="tit_s_i"> <?= $fecha?></td></tr>
			</table>		
		</td>
	</tr>
	<tr>
		<td colspan="6" background="images_factura/factura-r_07.jpg" width="704" height="65" alt=""></td>
	</tr>
	<tr valign="top">
		<td colspan="2" background="images_factura/factura-r_08.jpg" width="66" height="61" alt=""></td>
		<td colspan="4" background="images_factura/factura-r_09.jpg" width="638" height="61" alt="">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr><td height="32" class="txt_f_g" colspan="3">&nbsp;<?= $nombre?></td></tr>
			  <tr>
				<td width="58%" class="txt_f_g">&nbsp;<?= $direccion?></td>
				<td width="2%" class="tit_s_i">&nbsp;</td>
				<td width="40%" class="txt_f_g">&nbsp;<?= $tel?></td>
			  </tr>
		  </table>			
		</td>
	</tr>
	<tr>
		<td colspan="6" background="images_factura/factura-r_10.jpg" width="704" height="13" alt=""></td>
	</tr>
	<tr>
		<td colspan="3" background="images_factura/factura-r_11.jpg" width="343" height="83" alt=""></td>
		<td background="images_factura/factura-r_12.jpg" width="130" height="83" alt=""></td>
		<td colspan="2" background="images_factura/factura-r_13.jpg" width="231" height="83" alt="">
			<table width="98%" height="70" border="0" align="center" cellpadding="2" cellspacing="2">
			  <tr><td width="75%" class="txt_f_c"><?= $cuit?></td></tr>
			  <tr><td class="txt_f_c">&nbsp;</td></tr>
			  <tr><td class="txt_f_c"><?= $remito?></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="6" background="images_factura/factura-r_14.jpg" width="704" height="32" alt=""></td>
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
	$cant = $cant."<br>".$c;
	$detalle = $detalle."<br>&nbsp;&nbsp;".$producto;
	$total += $c;
}
?>
	<tr valign="top">
		<td align="center" class="txt_f">
			<table width="30%" align="center"><tr><td class="txt_f" align="center"><?= $cant?></td></tr></table>
		</td>
		<td background="images_factura/factura-r_16.jpg" width="10" height="484" alt=""></td>
		<td colspan="4" background="images_factura/factura-r_17.jpg" width="638" height="484" alt="">
			<table width="95%" align="center"><tr><td align="left" class="txt_f"><?= $detalle?></td></tr></table>
		</td>
	</tr>
	<tr>
		<td colspan="6" background="images_factura/factura-r_18.jpg" width="704" height="7" alt=""></td>
	</tr>
	<tr>
		<td colspan="5" background="images_factura/factura-r_19.jpg" width="595" height="33" alt=""></td>
		<td align="center" class="txt_f"><?= $total?>&nbsp;items</td>
	</tr>
	<tr>
		<td colspan="6" background="images_factura/factura-r_21.jpg" width="704" height="34" alt=""></td>
	</tr>
	<tr>
		<td colspan="6" background="images_factura/factura-r_22.jpg" width="704" height="55" alt=""></td>
	</tr>
	<tr>
		<td colspan="6" background="images_factura/factura-r_23.jpg" width="704" height="45" alt=""></td>
	</tr>
	<tr>
		<td background="images_factura/spacer.gif" width="8" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="56" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="10" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="277" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="130" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="122" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="109" height="1" alt=""></td>
		<td background="images_factura/spacer.gif" width="8" height="1" alt=""></td>
	</tr>
</table>

</td></tr></table>


</body>
</html>