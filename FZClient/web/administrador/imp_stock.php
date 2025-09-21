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
<p align="center" class="titulo"><img src="images/logo.jpg"></p>	
<table height="100%" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td valign="top" width="100%">
		<table width="600" align="center" border="0" cellpadding="0" cellspacing="0">
		  <tr height="20"><td class="titulo" align="center">Control de Stocks</td></tr>
		  <tr height="10"><td class="data" align="center">Fecha: <?= date(d."-".m."-".Y)?></td></tr>
		</table>

<?
$q_deposito = query("SELECT * FROM depositos ORDER BY deposito");
while($rs_q = mysql_fetch_array($q_deposito)){
	$q = query("SELECT * FROM stock WHERE id_deposito = " . $rs_q['id_deposito']." GROUP BY id_producto");
	if(mysql_num_rows($q)>0){
?>
	  <p align="center" class="titulo"><strong><?=$rs_q['deposito']?></strong></p>
	<table width="800" align="center" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	  <tr height="30">
		<td width="30%" class="encabezado" align="center">Linea</td>
		<td width="45%" class="encabezado" align="center">Producto</td>
		<td width="9%" class="encabezado" align="center">Q Sist.</td>
		<td width="9%" class="encabezado" align="center">Q Dep.</td>
		<td width="7%" class="encabezado" align="center">Dif.</td>
	  </tr>
	  <?
		$q_tipo = query("SELECT * FROM p_categorias ORDER BY orden");
		$cantidad_T = 0;
		$costo_T = 0; 	
		$reg = 0;
		while($rs_t = mysql_fetch_array($q_tipo)){
			$id_categoria = $rs_t['id_categoria'];
			$categoria = $rs_t['categoria'];
			$cantidad_p_T = 0;

			$q = query("SELECT p.id_producto, s.id_stock, s.cantidad, l.linea, v.variedad, v.sigla, pp.presentacion, pp.unidades, pp.volumen FROM stock s
						INNER JOIN productos p ON p.id_producto = s.id_producto 
						INNER JOIN p_categorias c ON c.id_categoria = p.id_categoria
						INNER JOIN p_lineas l ON l.id_linea = p.id_linea 
						INNER JOIN p_variedades v ON v.id_variedad = p.id_variedad
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE id_deposito = " . $rs_q['id_deposito']." && p.id_categoria = $id_categoria
						GROUP BY s.id_producto");
			if(mysql_num_rows($q) > 0){
			
				?>
				<tr height="20" bgcolor='#CCCCCC'>
					<td class="data">&nbsp;<b><?= $categoria?></b></td>
					<td class="data">&nbsp;</td>
					<td class="data" align="center">&nbsp;</td>
					<td class="data" align="center">&nbsp;</td>
					<td class="data" align="center">&nbsp;</td>
				</tr>
				<?
				while($rs=mysql_fetch_array($q)){
					$id_producto = $rs['id_producto'];
					$id_stock = $rs['id_stock'];
					$linea = $rs['linea'];
					$variedad = $rs['variedad'];
					$sigla = $rs['sigla'];
					$presentacion = $rs['presentacion']." (".$rs['unidades']." x ". $rs['volumen']." ml.)";
					
					if($variedad == " - Todas") $variedad = "";
					
					$producto = $variedad." - ". $presentacion;
					
					$cantidad = $rs['cantidad'];
					$costo = $rs['costo'];
	
					$cantidad_p_T += $cantidad;
					$cantidad_T += $cantidad;
					$costo_T += $costo * $cantidad;

			$reg += 1;
			?>
			<tr height="20">
				<td class="data">&nbsp;<?= $linea?></td>
				<td class="data">&nbsp;<?= $producto?></td>
				<td class="data" align="center"><?= $cantidad?></td>
				<td class="data" align="center">&nbsp;</td>
				<td class="data" align="center">&nbsp;</td>
			</tr>
				<? 	
					$tp = $rs['tipo_producto'];
				} // cierro el while de la consulta de stock
			?>
			<tr bgcolor="#CCCCCC">
				<td class="data" align="center">&nbsp;</td>
				<td class="data">&nbsp;</td>
				<td class="data" align="center"><b><?= number_format($cantidad_p_T, 0, ',', '.')?></b></td>
				<td class="data" align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
			</tr>	
		<? 
			} // cierro el if
		}
		?>
			<tr>
				<td class="data" colspan="5"></td>
			</tr>
			<tr height="30">
				<td class="data">&nbsp;</td>
				<td class="encabezado" align="center"><?= $reg?> Productos</td>
				<td class="data" align="center"><b><?= $cantidad_T?></b></td>
				<td class="data">&nbsp;</td>
				<td class="data">&nbsp;</td>
			</tr>
	  </table>
	<br>
  <? 
	}
	else{
		//echo("<p class='error' align='center'>No hay Stock cargado.</p>");
	}
}

?>


	  </td>
	</tr>
</table>
</body>
</html>
