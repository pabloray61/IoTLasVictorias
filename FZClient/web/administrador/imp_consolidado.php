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
		  <tr height="20"><td class="titulo" align="center">Consolidado de Productos</td></tr>
		  <tr height="10"><td class="data" align="center">Fecha: <?= date(d."-".m."-".Y)?></td></tr>
		</table>
<br>
	<table width="580" align="center">
	  <tr height="30"><td colspan="5" align="center" class="encabezado">LINEAS EN CAJAS</td></tr>
	  <tr>
		<td width="10">&nbsp;</td>
		<td width="190" class="encabezado" align="center">Linea</td>
		<td width="255" class="encabezado" align="center">Producto</td>
		<td width="65" class="encabezado" align="center">Cant</td>
		<td width="10">&nbsp;</td>
	  </tr>

<? // CAJAS ------------------------------------------------------------------------------------------------------------

	$cantidad_T = 0;
	$l_c = query("SELECT id_linea, linea FROM lineas WHERE linea LIKE '%x caja%'");
	while($rsl_c = mysql_fetch_array($l_c)){
		$id_linea_c = $rsl_c['id_linea'];
		$linea_c = $rsl_c['linea'];
		$cant_c_T = 0;
		$reg = 0;
		$qt_c = query("SELECT p.id_linea, l.linea, s.id_producto, p.producto, SUM(s.cantidad) AS cantidad FROM stock s 
						INNER JOIN productos p ON p.id_producto = s.id_producto 
						INNER JOIN lineas l ON p.id_linea = l.id_linea
						WHERE p.id_linea = $id_linea_c
						GROUP BY s.id_producto");
		if(mysql_num_rows($qt_c) > 0){
			while($rst_c = mysql_fetch_array($qt_c)){
				$bg = $flag ? "#efebdf":"#ffffff";
				$flag = !$flag;
				$producto_c = $rst_c['producto'];
				$cantidad_c = $rst_c['cantidad'];
				$cant_c_T += $cantidad_c;
				$cantidad_T += $cantidad_c;
				$reg += 1;
				$x_T += 1;
				?>
				<tr>
					<td class="data" align="center">&nbsp;</td>
					<td class="data">&nbsp;<?= $linea_c?></td>
					<td class="data">&nbsp;<?= $producto_c?></td>
					<td class="data" align="center"><?= number_format($cantidad_c, 0, ',', '.')?></td>
					<td align="center">&nbsp;</td>
				</tr>
				<? 
			}
		}
		else{
		?>
				<tr>
					<td class="data" align="center">&nbsp;</td>
					<td class="data">&nbsp;<?= $linea_c?></td>
					<td class="error" align="center">No hay stock cargado</td>
					<td class="data">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>
		<?
		}
		?>
		<tr height="25">
			<td class="data">&nbsp;</td>
			<td class="data">&nbsp;</td>
			<td class="data" style="border-top-style:ridge; border-top-width:thin; border-top-color:#000000" align="center"><b><?= $reg?> Registro<? if($reg != 1) echo("s")?></b></td>
			<td class="data" style="border-top-style:ridge; border-top-width:thin; border-top-color:#000000" align="center"><b><?= number_format($cant_c_T, 0, ',', '.')?></b></td>
			<td align="center">&nbsp;</td>
		</tr>
		<tr height="20"><td colspan="5" align="center" class="encabezado">&nbsp;</td></tr>
	<? }?>

	  <tr height="20"><td colspan="5" align="center" class="encabezado"></td></tr>
	  <tr height="30"><td colspan="5" align="center" class="encabezado">LINEAS EN BOTELLAS</td></tr>
	  <tr>
		<td width="10">&nbsp;</td>
		<td width="190" class="encabezado" align="center">Linea</td>
		<td width="255" class="encabezado" align="center">Producto</td>
		<td width="65" class="encabezado" align="center">Cant</td>
		<td width="10">&nbsp;</td>
	  </tr>
<? // BOTELLAS ------------------------------------------------------------------------------------------------------------

	$l_b = query("SELECT id_linea, linea FROM lineas WHERE linea LIKE '%x botella%'");
	while($rsl_b = mysql_fetch_array($l_b)){
		$id_linea_b = $rsl_b['id_linea'];
		$linea_b = $rsl_b['linea'];
		$cant_b_T = 0;
		$reg = 0;
		$x_T += 1;
		$qt_b = query("SELECT p.id_linea, l.linea, s.id_producto, p.producto, SUM(s.cantidad) AS cantidad FROM stock s 
						INNER JOIN productos p ON p.id_producto = s.id_producto 
						INNER JOIN lineas l ON p.id_linea = l.id_linea
						WHERE p.id_linea = $id_linea_b
						GROUP BY s.id_producto");
		if(mysql_num_rows($qt_b) > 0){
			while($rst_b = mysql_fetch_array($qt_b)){
				$bg = $flag ? "#efebdf":"#ffffff";
				$flag = !$flag;
				$producto_b = $rst_b['producto'];
				$cantidad_b = $rst_b['cantidad'];
				$cant_b_T += $cantidad_b;
				$cantidad_T += $cantidad_b;
				$reg += 1;
				?>
				<tr>
					<td class="data" align="center">&nbsp;</td>
					<td class="data">&nbsp;<?= $linea_b?></td>
					<td class="data">&nbsp;<?= $producto_b?></td>
					<td class="data" align="center"><?= number_format($cantidad_b, 0, ',', '.')?></td>
					<td align="center">&nbsp;</td>
				</tr>
			    <? 
			}
		}
		else{
		?>
				<tr>
					<td class="data" align="center">&nbsp;</td>
					<td class="data">&nbsp;<?= $linea_b?></td>
					<td class="error" align="center">No hay stock cargado</td>
					<td class="data">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>
		<?
		}
		?>
		<tr height="25">
			<td class="data">&nbsp;</td>
			<td class="data">&nbsp;</td>
			<td style="border-top-style:ridge; border-top-width:thin; border-top-color:#000000" class="data" align="center"><b><?= $reg?> Registro<? if($reg != 1) echo("s")?></b></td>
			<td style="border-top-style:ridge; border-top-width:thin; border-top-color:#000000" class="data" align="center"><b><?= number_format($cant_b_T, 0, ',', '.')?></b></td>
			<td align="center">&nbsp;</td>
		</tr>
		<tr height="20"><td colspan="5" align="center" class="encabezado">&nbsp;</td></tr>
	<? }?>
	  <tr height="20"><td colspan="5" align="center" class="encabezado"></td></tr>
	  <tr height="30"><td colspan="5" align="center" class="encabezado">OTRAS LINEAS</td></tr>
	  <tr>
		<td width="10">&nbsp;</td>
		<td width="190" class="encabezado" align="center">Linea</td>
		<td width="255" class="encabezado" align="center">Producto</td>
		<td width="65" class="encabezado" align="center">Cant</td>
		<td width="10">&nbsp;</td>
	  </tr>
<? // OTROS ------------------------------------------------------------------------------------------------------------

	$l_o = query("SELECT id_linea, linea FROM lineas WHERE linea NOT LIKE '%x caja%' AND linea NOT LIKE '%x botella%'");
	while($rsl_o = mysql_fetch_array($l_o)){
		$id_linea_o = $rsl_o['id_linea'];
		$linea_o = $rsl_o['linea'];
		$cant_o_T = 0;
		$reg = 0;
		$x_T += 1;
		$qt_o = query("SELECT p.id_linea, l.linea, s.id_producto, p.producto, SUM(s.cantidad) AS cantidad FROM stock s 
						INNER JOIN productos p ON p.id_producto = s.id_producto 
						INNER JOIN lineas l ON p.id_linea = l.id_linea
						WHERE p.id_linea = $id_linea_o
						GROUP BY s.id_producto");
		if(mysql_num_rows($qt_o) > 0){
			while($rst_o = mysql_fetch_array($qt_o)){
				$bg = $flag ? "#efebdf":"#ffffff";
				$flag = !$flag;
				$producto_o = $rst_o['producto'];
				$cantidad_o = $rst_o['cantidad'];
				$cant_o_T += $cantidad_o;
				$cantidad_T += $cantidad_o;
				$reg += 1;
				?>
				<tr>
					<td class="data" align="center">&nbsp;</td>
					<td class="data">&nbsp;<?= $linea_o?></td>
					<td class="data">&nbsp;<?= $producto_o?></td>
					<td class="data" align="center"><?= number_format($cantidad_o, 0, ',', '.')?></td>
					<td align="center">&nbsp;</td>
				</tr>
			    <? 
			}
		}
		else{
		?>
				<tr>
					<td class="data" align="center">&nbsp;</td>
					<td class="data">&nbsp;<?= $linea_o?></td>
					<td class="error" align="center">No hay stock cargado</td>
					<td class="data">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>
		<?
		}
		?>
		<tr height="25">
			<td class="data">&nbsp;</td>
			<td class="data">&nbsp;</td>
			<td style="border-top-style:ridge; border-top-width:thin; border-top-color:#000000" class="data" align="center"><b><?= $reg?> Registro<? if($reg != 1) echo("s")?></b></td>
			<td style="border-top-style:ridge; border-top-width:thin; border-top-color:#000000" class="data" align="center"><b><?= number_format($cant_o_T, 0, ',', '.')?></b></td>
			<td align="center">&nbsp;</td>
		</tr>
		<tr height="20"><td colspan="5" align="center" class="encabezado">&nbsp;</td></tr>
	<? }?>

		<tr height="30"><td class="data" colspan="6"></td></tr>
		<tr height="30"><td colspan="5" align="center" class="encabezado">CONSOLIDADO TOTAL</td></tr>
		<tr>
			<td class="data"></td>
			<td class="data"></td>
			<td class="data"></td>
			<td class="data"></td>
			<td></td>
		</tr>
		<tr height="30">
			<td class="data">&nbsp;</td>
			<td class="data">&nbsp;<b>Total</b></td>
			<td class="data" align="center"><b><?= $x_T?> Registros</b></td>
			<td class="data" align="center"><b><?= number_format($cantidad_T, 0, ',', '.')?></b></td>
			<td align="center">&nbsp;</td>
		</tr>
	  </table>


	  </td>
	</tr>
</table>
</body>
</html>
