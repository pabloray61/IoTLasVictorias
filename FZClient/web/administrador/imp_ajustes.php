<? require("conn.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}
?>
<html>
<head>
<title>ACORDES .::. Selected Brands .::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilo.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style></head>

<body>
<?
$buscar = $_REQUEST['buscar'];
$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];
$fecha_d = $_REQUEST['fecha_d'];
$fecha_h= $_REQUEST['fecha_h'];

list($ano_d, $mes_d, $dia_d) = split( '[/.-]', $fecha_d);
$f_d = $dia_d."/".$mes_d."/".$ano_d;
list($ano_h, $mes_h, $dia_h) = split( '[/.-]', $fecha_h);
$f_h = $dia_h."/".$mes_h."/".$ano_h;

if($fecha_d != "") $txt = " desde ".$f_d." hasta ".$f_h;
$mes_a = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
if($mes != ""  && $mes != 0) $txt = " en el mes de ".$mes_a[$mes];
if($ano != ""  && $ano != 0) $txt .= " del año ".$ano;
?>
<table height="100%" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td valign="top" width="100%">
		<table width="600" align="center" border="0" cellpadding="0" cellspacing="0">
		  <tr height="20"><td class="titulo" align="center">Ajustes Realizados <?= $txt?></td></tr>
		  <tr height="10"><td class="data" align="center">Fecha de impresion: <?= date(d."-".m."-".Y)?></td></tr>
		</table>
<?
if($buscar == 1){
	$ano = date(Y);
	$mes = date(m);
}

if($mes > 0){ 
	$mes_s = "WHERE month(fecha)=" . $mes;
	$fecha_d = '';
	$fecha_h = '';
}
if($ano > 0){ 
	$ano_s = "year(fecha)=" . $ano;
	$fecha_d = '';
	$fecha_h = '';
	if($mes > 0) $mes_s = $mes_s . " && ";
	if($mes == 0) $ano_s = "WHERE ".$ano_s;
}
if($fecha_d != "")	$f = "WHERE fecha >= '$fecha_d' && fecha <= '$fecha_h'";
if($f == "--") $f = "";

$q = query("SELECT * FROM mermas $f $mes_s $ano_s");

if(mysql_num_rows($q)>0){
?>
	<table width="650" align="center" border="0">
		<tr><td colspan="5" align="center" class="titulo">&nbsp;</td></tr>
		<tr><td colspan="5" align="center" class="titulo">&nbsp;</td></tr>
		<tr>
			<td width="80" class="encabezado" align="center">Fecha</td>
			<td width="270" class="encabezado" align="center">Producto</td>
			<td width="180" class="encabezado" align="center">Deposito</td>
			<td width="70" class="encabezado" align="center">Ajuste</td>
			<td width="30">&nbsp;</td>
		</tr>
		<tr height="5"><td colspan="5" style="border-top-style:ridge; border-top-width:thin; border-top-color:#000000"><img src="images/spacer.gif"></td></tr>
		<?
		$cantidad_T = 0;
		$costo_T = 0; 		
		while($rs=mysql_fetch_array($q)){
			$id_producto = $rs['id_producto'];		
			$qp = query("SELECT * FROM productos WHERE id_producto = $id_producto");
			$rp = mysql_fetch_array($qp);
			$producto = $rp['producto'];
				$len = strlen($producto);
				if($len > 40){ // Si es muy largo le saco parte del medio
					$s = $len - 17;
					$p1 = substr($producto, 0, 23); 
					$p2 = substr($producto, $s, 17); 
					$producto = $p1 ." ... ". $p2;
				} 
			$id_deposito = $rs['id_deposito'];		
			$qd = query("SELECT * FROM depositos WHERE id_deposito = $id_deposito");
			$rd = mysql_fetch_array($qd);
			$deposito = $rd['deposito'];
				$len = strlen($deposito);
				if($len > 43){ // Si es muy largo le saco parte del medio
					$s = $len - 17;
					$p1 = substr($deposito, 0, 26); 
					$p2 = substr($deposito, $s, 17); 
					$deposito = $p1 ." ... ". $p2;
				} 
			$fecha = $rs['fecha'];
			list($ano, $mes, $dia) = split( '[/.-]', $fecha);
			$ano = substr($ano, 2,2);
			$fecha = $dia."/".$mes."/".$ano;
			$cantidad = $rs['cantidad'];

			$cantidad_T += $cantidad;

			$reg += 1;
			?>
			<tr>
				<td class="data" align="center"><?= $fecha?></td>
				<td class="data">&nbsp;<?= $producto?></td>
				<td class="data" align="center"><?= $deposito?></td>
				<td class="data" align="center"><?= number_format($cantidad, 0, ',', '.')?></td>
				<td align="center">&nbsp;</td>
			</tr>
		<? }?>
			<tr height="5"><td colspan="5" style="border-top-style:ridge; border-top-width:thin; border-top-color:#000000"><img src="images/spacer.gif"></td></tr>
			<tr>
				<td class="data">&nbsp;</td>
				<td class="data" align="center"><b><?= $reg?> registros</b></td>
				<td class="data" align="center">&nbsp;</td>
				<td class="data" align="center"><b><?= $cantidad_T?></b></td>
				<td align="center">&nbsp;</td>
			</tr>
	  </table>
	<br>
  <? }?>


	  </td>
	</tr>
</table>
</body>
</html>
