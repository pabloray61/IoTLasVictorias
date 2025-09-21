<? require("conn.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}
?>
<html>
<head>
<title>ACORDES .::. Selected Brands .::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
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

<p align="center" class="titulo"><img src="images/logo.jpg"></p>	
<p align="center" class="titulo">Listado de Productos</p>

	<table width="400" align="center" cellpadding="0" cellspacing="0">
	  <tr height="30" valign="bottom">
		<td width="30%" class="encabezado" align="right">Fecha:&nbsp;&nbsp;</td>
		<td width="70%" class="encabezado" align="center" style="border-bottom-style:dotted; border-bottom-width:thin; border-bottom-color:#000000">&nbsp;</td>
	  </tr>
	  <tr height="30" valign="bottom">
		<td width="30%" class="encabezado" align="right">Responsable:&nbsp;&nbsp;</td>
		<td width="70%" class="encabezado" align="center" style="border-bottom-style:dotted; border-bottom-width:thin; border-bottom-color:#000000">&nbsp;</td>
	  </tr>
	</table>
<br>
	<table width="800" align="center" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	  <tr height="30">
		<td width="25%" class="encabezado" align="center">Linea</td>
		<td width="45%" class="encabezado" align="center">Producto</td>
		<td width="15%" class="encabezado" align="center">Q Dep.</td>
		<td width="15%" class="encabezado" align="center">Dif.</td>
	  </tr>
	  <?
		$cantidad_T = 0;
		$costo_T = 0;

		$q_tipo = query("SELECT * FROM p_categorias ORDER BY orden");
		while($rs_t = mysql_fetch_array($q_tipo)){
			$id_categoria = $rs_t['id_categoria'];
			$categoria = $rs_t['categoria'];
			
			$qp = query("SELECT p.id_producto, p.ue, pl.linea, pv.variedad, pv.sigla, pp.presentacion, pp.unidades, pp.volumen, p.orden FROM productos p
						INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
						INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE p.id_categoria = $id_categoria	ORDER BY p.orden");
			?>
			<tr height="20" bgcolor='#CCCCCC'>
				<td class="data">&nbsp;<b><?= $categoria?></b></td>
				<td class="data">&nbsp;</td>
				<td class="data" align="center">&nbsp;</td>
				<td class="data" align="center">&nbsp;</td>
			</tr>
			<?
			while($rs = mysql_fetch_array($qp)){
				$id_producto = $rs['id_producto'];
				$linea = $rs['linea'];
				$variedad = $rs['variedad'];
				$sigla = $rs['sigla'];
				$presentacion = $rs['presentacion']." (".$rs['unidades']." x ". $rs['volumen']." ml.)";
				
				if($variedad == " - Todas") $variedad = "";
				
				$producto = $variedad." - ". $presentacion;
				
				$cantidad = $rs['cantidad'];
				$costo = $rs['costo'];
	
				$cantidad_T += $cantidad;
				$costo_T += $costo * $cantidad; 
	
				$reg += 1;
				if($lin != $rp['linea'] && $reg != 1){
					echo("<tr bgcolor='#CCCCCC'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>");
				}
				$lin = $rp['linea'];
				?>
				<tr height="20">
					<td class="data">&nbsp;<?= $linea?></td>
					<td class="data">&nbsp;<?= $producto?></td>
					<td class="data" align="center">&nbsp;</td>
					<td class="data" align="center">&nbsp;</td>
				</tr>
			<? }?>
		<? }?>			
		<tr>
			<td class="data" colspan="4"></td>
		</tr>
		<tr height="30">
			<td class="data">&nbsp;</td>
			<td class="encabezado" align="center"><?= $reg?> Productos</td>
			<td class="data">&nbsp;</td>
			<td class="data">&nbsp;</td>
		</tr>
  </table>
	<br>



	  </td>
	</tr>
</table>
</body>
</html>
