<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

?>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>
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

	
<p align="center" class="titulo">Valoracion del Stocks</p>

<?
$q_deposito = query("SELECT * FROM depositos ORDER BY deposito");
while($rs_q = mysql_fetch_array($q_deposito)){
	$q = query("SELECT * FROM stock WHERE id_deposito = " . $rs_q['id_deposito']." GROUP BY id_producto");
	if(mysql_num_rows($q)>0){
?>
	  <p align="center" class="titulo"><strong><?=$rs_q['deposito']?></strong></p>
	<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
	  <tr height="30">
		<td width="3%" class="t">&nbsp;</td>
		<td width="24%" class="t" align="center">Categoria</td>
		<td width="50%" class="t" align="center">Producto</td>
		<td width="10%" class="t" align="center">Cant</td>
		<td width="10%" class="t" align="center">$ Pond.</td>
		<td width="3%" class="t">&nbsp;</td>
	  </tr>
	  <?
		$q_tipo = query("SELECT * FROM p_categorias ORDER BY orden");
		$cantidad_T = 0;
		$costo_T = 0; 
		while($rs_t = mysql_fetch_array($q_tipo)){
			$id_categoria = $rs_t['id_categoria'];
			$categoria = $rs_t['categoria'];
			$cantidad_p_T = 0;
			$costo_p_T = 0;
			$q = query("SELECT p.id_producto, s.id_stock, s.cantidad, l.linea, v.variedad, v.sigla, pp.presentacion, pp.unidades, 
						pp.volumen, (SELECT SUM(costo)/count(*) FROM produccion WHERE id_producto = p.id_producto) AS costo_ponderado 
						FROM stock s
						INNER JOIN productos p ON p.id_producto = s.id_producto 
						INNER JOIN p_categorias c ON c.id_categoria = p.id_categoria
						INNER JOIN p_lineas l ON l.id_linea = p.id_linea 
						INNER JOIN p_variedades v ON v.id_variedad = p.id_variedad
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE id_deposito = " . $rs_q['id_deposito']." && p.id_categoria = $id_categoria
						GROUP BY s.id_producto");
			if(mysql_num_rows($q) > 0){
				while($rs=mysql_fetch_array($q)){
					$id_producto = $rs['id_producto'];
					$id_stock = $rs['id_stock'];
					$linea = $rs['linea'];
					$variedad = " - ".$rs['variedad'];
					$sigla = $rs['sigla'];
					$presentacion = $rs['presentacion']." (".$rs['unidades']." x ". $rs['volumen']." ml.)";
					
					if($variedad == " - Todas") $variedad = "";
					
					$producto = $linea."".$variedad." - ". $presentacion;
		
					$cantidad = $rs['cantidad'];
					$costo_ponderado = $rs['costo_ponderado'];
	
					$cantidad_p_T += $cantidad;
					$cantidad_T += $cantidad;
					$costo_p_T += $costo_ponderado * $cantidad;
					$costo_T += $costo_ponderado * $cantidad; 
		
					$reg += 1;
					$c = $flag ? "c1":"c2";
					$flag = !$flag;
					?>
					<tr height="30">
						<td class="<?= $c?>" align="center">&nbsp;</td>
						<td class="<?= $c?>" align="center">&nbsp;<?= $categoria?></td>
						<td class="<?= $c?>">&nbsp;<?= $producto?></td>
						<td class="<?= $c?>" align="center"><?= number_format($cantidad, 0, ',', '.')?></td>
						<td class="<?= $c?>" align="center">$&nbsp;<?= number_format($costo_ponderado, 2, ',', '.')?></td>
						<td class="<?= $c?>">&nbsp;</td>
					</tr>
				<? 	
					$tp = $rs['tipo_producto'];
				} // cierro el while de la consulta de stock
			?>
			<tr height="25">
				<td class="t2" align="center">&nbsp;</td>
				<td class="t2" align="center"><b><?= $tipo_producto?></b></td>
				<td class="t2">&nbsp;</td>
				<td class="t2" align="center"><b><?= number_format($cantidad_p_T, 0, ',', '.')?></b></td>
				<td class="t2" align="center"><b>$&nbsp;<?= number_format($costo_p_T, 2, ',', '.')?></b></td>
				<td class="t2">&nbsp;</td>
			</tr>	
		<? 
			} // cierro el if
		}
		?>
		<tr height="30">
			<td class="t">&nbsp;</td>
			<td class="t">&nbsp;</td>
			<td class="t"><?= $x?></td>
			<td class="t" align="center"><b><?= number_format($cantidad_T, 0, ',', '.')?></b></td>
			<td class="t" align="center"><b>$&nbsp;<?= number_format($costo_T, 2, ',', '.')?></b></td>
			<td class="t">&nbsp;</td>
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
