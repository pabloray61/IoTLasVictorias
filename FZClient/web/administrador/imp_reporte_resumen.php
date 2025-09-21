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

<table width="600" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><td align="center"><img src="images/logo.jpg"></td></tr>
	<tr height="10"><td></td></tr>
	<tr height="20"><td class="titulo" align="center"><b>ACORDES - RESUMEN</b></td></tr>
	<tr height="10"><td class="data" align="center">Fecha de impresion: <?= date(d."-".m."-".Y)?></td></tr>
	<tr height="20"><td></td></tr>
</table>
<?
$anos = array();
$i = 0;
$a = query("SELECT year(fecha) AS ano FROM ventas WHERE year(fecha) <> '' GROUP BY ano");
while($rs = mysql_fetch_array($a)){
	$anos[$i] = $rs['ano'];
	$i++;
}
$meses = array('ENE','FEB', 'MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT', 'NOV','DIC');

$datos = array();
array_push($datos,array());  // AGREGO UN ARREGLO DENTRO DE OTRO

if($_SESSION['admin'] != "ok") $w = " AND v.id_vendedor = " . $_SESSION['id_vendedor'];

$a = 0;
foreach($anos as $ano){ 
	for($m = 1; $m < 13; $m++){
		$sql = "SELECT month(fecha), year(fecha),
					SUM( CASE WHEN unidades = 1 AND regalo != 1 THEN vd.cant ELSE 0 END ) AS botellas, 
					SUM( CASE WHEN unidades = 1 AND regalo = 1 THEN vd.cant ELSE 0 END ) AS bb, 
					SUM( CASE WHEN unidades > 1 AND regalo != 1 THEN vd.cant ELSE 0 END ) AS cajas, 
					SUM( CASE WHEN unidades > 1 AND regalo = 1 THEN vd.cant ELSE 0 END ) AS cb, 
					ROUND((SUM(vd.precio * vd.cant) * (1 - v.dto_porc/100) - v.dto_fijo)*100)/100 AS monto_sd,
					ROUND(SUM(CASE WHEN regalo != 1 THEN vd.precio_final * vd.cant ELSE 0 END)) AS monto
					FROM ventas v 
					INNER JOIN ventas_detalle vd on vd.id_venta = v.id_venta 
					INNER JOIN productos p ON p.id_producto = vd.id_producto 
					INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion 
					WHERE year(fecha) = '$ano' AND month(fecha) = '$m' $w
					GROUP BY month(fecha)";
		//echo ($sql."<br><br>");
		$q = query($sql);
		if(mysql_num_rows($q) > 0){
			$rs = mysql_fetch_array($q);
			$botellas = $rs['botellas'];
			$bb = $rs['bb'];
			$cajas = $rs['cajas'];
			$cb = $rs['cb'];
			$monto = $rs['monto'];
			if($monto == "") $monto = $rs['monto_sd'];
		}else{
			$botellas = 0;
			$cajas = 0;
			$monto = 0;
			$bb = 0;
			$cb = 0;
		}
		$datos[$a][$m][0] = $botellas;
		$datos[$a][$m][1] = $cajas;
		$datos[$a][$m][2] = $monto;
		$datos[$a][$m][3] = $bb;
		$datos[$a][$m][4] = $cb;		
	}
	$a++;
}

?>
<!-- -------------- BOTELLAS -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="encabezado" height="30"> 
		<td class="encabezado" width="8%" align="center"><b>BOTELLAS</b></td>
			<? foreach($meses as $mes){ ?>
				<td class="encabezado" width="7%" align="center"><b><?= $mes?></td>
			<? }?>
		<td class="encabezado" width="8%" align="center"><b>TOTAL</td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="encabezado" align="center"><b><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="data" align="center"><?= number_format($datos[$a][$m][0], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][0];
				$mes_T[$m] += $datos[$a][$m][0];
				$total += $datos[$a][$m][0];
				?>
			<? }?>
			<td class="encabezado" align="center"><b><?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<tr height="1" bgcolor="#000000"><td colspan="14"></td></tr>
		<? $a++;
	}?>
	<tr height="1" bgcolor="#000000"><td colspan="14"></td></tr>
	<tr height="30">
		<td class="encabezado" align="center"><b>TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="encabezado" align="center"><b><?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="encabezado" align="center"><b><?= number_format($total, 0, ',','.')?></td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
</table>
<br><br>
<!-- -------------- CAJAS -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="encabezado" height="30">
		<td class="encabezado" width="8%" align="center"><b>CAJAS</b></td>
			<? foreach($meses as $mes){ ?>
				<td class="encabezado" width="7%" align="center"><b><?= $mes?></td>
			<? }?>
		<td class="encabezado" width="8%" align="center"><b>TOTAL</td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="encabezado" align="center"><b><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="data" align="center"><?= number_format($datos[$a][$m][1], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][1];
				$mes_T[$m] += $datos[$a][$m][1];

				$total += $datos[$a][$m][1];
				?>
			<? }?>
			<td class="encabezado" align="center"><b><?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<tr height="1" bgcolor="#000000"><td colspan="14"></td></tr>
		<? $a++;
	}?>
	<tr height="1" bgcolor="#000000"><td colspan="14"></td></tr>
	<tr height="30">
		<td class="encabezado" align="center"><b>TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="encabezado" align="center"><b><?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="encabezado" align="center"><b><?= number_format($total, 0, ',','.')?></td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
</table>
<br><br>
<!-- -------------- MONTOS -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="encabezado" height="30">
		<td class="encabezado" width="8%" align="center"><b>MONTOS</b></td>
			<? foreach($meses as $mes){ ?>
				<td class="encabezado" width="7%" align="center"><b><?= $mes?></td>
			<? }?>
		<td class="encabezado" width="8%" align="center"><b>TOTAL</td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="encabezado" align="center"><b><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="data" align="center">$&nbsp;<?= number_format($datos[$a][$m][2], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][2];
				$mes_T[$m] += $datos[$a][$m][2];
				$total += $datos[$a][$m][2];
				?>
			<? }?>
			<td class="encabezado" align="center"><b>$&nbsp;<?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<tr height="1" bgcolor="#000000"><td colspan="14"></td></tr>		
		<? $a++;
	}?>
	<tr height="1" bgcolor="#000000"><td colspan="14"></td></tr>
	<tr height="30">
		<td class="encabezado" align="center"><b>TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="encabezado" align="center"><b>$&nbsp;<?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="encabezado" align="center"><b>$&nbsp;<?= number_format($total, 0, ',','.')?></td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
</table>
<br><br>
<!-- -------------- BB -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="encabezado" height="30"> 
		<td class="encabezado" width="8%" align="center"><b>BOTELLAS</b></td>
			<? foreach($meses as $mes){ ?>
				<td class="encabezado" width="7%" align="center"><b><?= $mes?></td>
			<? }?>
		<td class="encabezado" width="8%" align="center"><b>TOTAL</td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="encabezado" align="center"><b><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="data" align="center"><?= number_format($datos[$a][$m][3], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][3];
				$mes_T[$m] += $datos[$a][$m][3];
				$total += $datos[$a][$m][3];
				?>
			<? }?>
			<td class="encabezado" align="center"><b><?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<tr height="1" bgcolor="#000000"><td colspan="14"></td></tr>
		<? $a++;
	}?>
	<tr height="1" bgcolor="#000000"><td colspan="14"></td></tr>
	<tr height="30">
		<td class="encabezado" align="center"><b>TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="encabezado" align="center"><b><?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="encabezado" align="center"><b><?= number_format($total, 0, ',','.')?></td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
</table>
<br><br>
<!-- -------------- CB -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="encabezado" height="30">
		<td class="encabezado" width="8%" align="center"><b>CAJAS</b></td>
			<? foreach($meses as $mes){ ?>
				<td class="encabezado" width="7%" align="center"><b><?= $mes?></td>
			<? }?>
		<td class="encabezado" width="8%" align="center"><b>TOTAL</td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="encabezado" align="center"><b><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="data" align="center"><?= number_format($datos[$a][$m][4], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][4];
				$mes_T[$m] += $datos[$a][$m][4];

				$total += $datos[$a][$m][4];
				?>
			<? }?>
			<td class="encabezado" align="center"><b><?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<tr height="1" bgcolor="#000000"><td colspan="14"></td></tr>
		<? $a++;
	}?>
	<tr height="1" bgcolor="#000000"><td colspan="14"></td></tr>
	<tr height="30">
		<td class="encabezado" align="center"><b>TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="encabezado" align="center"><b><?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="encabezado" align="center"><b><?= number_format($total, 0, ',','.')?></td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
</table>
<br><br>



</body>
</html>
