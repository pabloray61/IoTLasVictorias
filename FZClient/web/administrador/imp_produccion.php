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
<table height="100%" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td valign="top" width="100%">
		<table width="600" align="center" border="0" cellpadding="0" cellspacing="0">
		  <tr height="20"><td class="titulo" align="center">Lotes de Produccion</td></tr>
		  <tr height="10"><td class="data" align="center">Fecha: <?= date(d."-".m."-".Y)?></td></tr>
		</table>

<?
$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];
$fecha_d = $_REQUEST['fecha_d'];
$fecha_h = $_REQUEST['fecha_h'];

if($mes > 0){ 
	$mes_s = " && month(fecha)=" . $mes;
	$fecha_d = '';
	$fecha_h = '';
}
if($ano > 0){ 
	$ano_s = "year(fecha)=" . $ano;
	$fecha_d = '';
	$fecha_h = '';
	if($mes > 0) $mes_s = $mes_s . " && ";
	if($mes == 0) $ano_s = " && ".$ano_s;
}
if($fecha_d != "")	$f = "&& fecha >= '$fecha_d' && fecha <= '$fecha_h'";
if($f == "--") $f = "";

//echo("SELECT * FROM produccion WHERE id_deposito = " . $rs_q['id_deposito']." $f $mes_s $ano_s<br>");

$q_deposito = query("SELECT * FROM depositos ORDER BY deposito");
while($rs_q = mysql_fetch_array($q_deposito)){
	$q = query("SELECT * FROM produccion WHERE id_deposito = " . $rs_q['id_deposito']." $f $mes_s $ano_s");
?>
	  <p align="center" class="titulo"><strong><?=$rs_q['deposito']?></strong></p>
<?
	if(mysql_num_rows($q)>0){
?>

	<table width="600" align="center" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	  <tr height="30">
		<td width="10%" class="encabezado" align="center">Fecha</td>
		<td width="30%" class="encabezado" align="center">Linea</td>
		<td width="35%" class="encabezado" align="center">Producto</td>
		<td width="10%" class="encabezado" align="center">Cant.</td>
		<td width="15%" class="encabezado" align="center">Costo</td>
	  </tr>
	  <?
		$cantidad_T = 0;
		$costo_T = 0; 		
		while($rs=mysql_fetch_array($q)){
			$id_producto = $rs['id_producto'];
			$id_produccion = $rs['id_produccion'];
		
			$qp = query("SELECT * FROM productos p INNER JOIN lineas l ON l.id_linea = p.id_linea WHERE id_producto = $id_producto");
			$rp = mysql_fetch_array($qp);
			$linea = $rp['linea'];
				$len_l = strlen($linea);
				if($len_l > 25){ // Si es muy largo le saco parte del medio
					$s = $len_l - 11;
					$p1 = substr($linea, 0, 14); 
					$p2 = substr($linea, $s, 11); 
					$linea = $p1 ."...". $p2;
				} 
			$producto = $rp['producto'];
				$len = strlen($producto);
				if($len > 30){ // Si es muy largo le saco parte del medio
					$s = $len - 13;
					$p1 = substr($producto, 0, 18); 
					$p2 = substr($producto, $s, 13); 
					$producto = $p1 ."...". $p2;
				} 
			$fecha = $rs['fecha'];
			list($ano, $mes, $dia) = split( '[/.-]', $fecha);
			$ano = substr($ano, 2,2);
			$fecha = $dia."/".$mes."/".$ano;
			$cantidad = $rs['cantidad'];
			$costo = $rs['costo'];

			$cantidad_T += $cantidad;
			$costo_T += $costo * $cantidad; 

			$reg += 1;
			$bg = $flag ? "#efebdf":"#ffffff";
			$flag = !$flag;
			?>
			<tr height="20">
				<td class="data" align="center"><?= $fecha?></td>
				<td class="data">&nbsp;<?= $linea?></td>
				<td class="data">&nbsp;<?= $producto?></td>
				<td class="data" align="center"><?= number_format($cantidad, 0, ',', '.')?></td>
				<td class="data" align="center"><?= number_format($costo, 2, ',', '.')?></td>
			</tr>
		<? }?>
			<tr>
				<td class="data" colspan="6"></td>
			</tr>
			<tr height="30">
				<td class="data">&nbsp;</td>
				<td class="data">&nbsp;</td>
				<td class="data" align="center"><?= $reg?> registros.</td>
				<td class="data" align="center"><?= number_format($cantidad_T, 0, ',', '.')?></td>
				<td class="data" align="center"><?= number_format($costo_T, 2, ',', '.')?></td>
			</tr>
	  </table>
	<br>
  <? 
	}
	else{
		echo("<p class='error' align='center'>No hay Stock cargado.</p>");
	}
}

?>


	  </td>
	</tr>
</table>
</body>
</html>
