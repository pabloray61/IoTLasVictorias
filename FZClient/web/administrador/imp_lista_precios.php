<? 
require("conn.php");
require("func.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}
?>
<html>
<head>
<title>ACORDES .::. Selected Brands .::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
<?
$id_lista = $_REQUEST['id_lista'];
if($_REQUEST['id_lista'] != 0){
	$ql = query("SELECT * FROM listas WHERE id_lista = $id_lista");
	$rsl = mysql_fetch_array($ql);
	$lista = "&#8220;".$rsl['lista']."&#8221;";
}
$fecha = $_REQUEST['fecha'];		
$tipo = $_REQUEST['tipo'];

if($tipo == 1) $tx = "(Con IVA)";
if($tipo == 2) $tx = "(Sin IVA)";
list($ano, $mes, $dia) = split( '[/.-]', $fecha);
$fec = $dia."/".$mes."/".$ano;
?>
<table height="100%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" width="100%">
        	<p align="center" class="titulo"><img src="images/logo.jpg"></p>
			<p align="center" class="titulo">Lista de Precios <?= $lista?> <?= $tx?> - <?= $fec?></p>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr height="40">
					<td align="center">
						<form method="post" name="filtro" action="<?=$_SERVER['PHP_SELF']?>">
							<select name="id_lista" onChange="filtro.submit();">
								<option value="0" <? if($id_lista == 0) echo('SELECTED')?>>Todas</option>
							<?
								$ql = query("SELECT * FROM listas ORDER BY lista");
								while($rsl = mysql_fetch_array($ql)){
									?>
									<option value="<?= $rsl['id_lista']?>" <? if($rsl['id_lista'] == $id_lista) echo('SELECTED')?>><?= $rsl['lista']?></option>
								<? }?>
							</select>
							<input type="hidden" name="tipo" value="<?= $tipo?>">
							<input type="hidden" name="fecha" value="<?= $fecha?>">
						</form>
					</td>
				</tr>
			</table>
			<?		
			if($_REQUEST['id_lista'] != 0){
			?>
				<table width="800" align="center" cellpadding="0" cellspacing="1">
					<?
					$q1 = query("SELECT p.id_categoria, categoria, p.id_linea, linea FROM productos p
								INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
								INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
								GROUP BY linea
								ORDER BY p.orden");
					while($rs1 = mysql_fetch_array($q1)){
						$id_categoria = $rs1['id_categoria'];
						$id_linea = $rs1['id_linea'];
						$categoria = $rs1['categoria'];
						$linea = $rs1['linea'];
						?>
						<tr height="40">
							<td width="70%" class="dataBold" bgcolor="#999999">&nbsp;&nbsp;&nbsp;<?= $categoria." ".$linea?></td>
							<td width="30%" align="center" title="<?= $listas?>" bgcolor="#999999" class="dataBold">Precios: <?= $lista?></td>
						</tr>
						<tr height="1"><td bgcolor="#333333" colspan="2"></td></tr>
						<?
						$q2 = query("SELECT p.id_producto, variedad, pv.sigla, presentacion, unidades, volumen FROM productos p
									INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
									INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
									WHERE p.id_categoria = $id_categoria AND p.id_linea = $id_linea
									ORDER BY p.orden");
						while($rs2 = mysql_fetch_array($q2)){
							$c = $flag ? "c1":"c2";
							$flag =! $flag;	
							$id_producto = $rs2['id_producto'];
							$q3 = query("SELECT * FROM precios WHERE id_producto = $id_producto AND id_lista= $id_lista  AND fecha= '$fecha'");
							$rs3 = mysql_fetch_array($q3);
							?>
							<tr height="30">
								<td class="data" title="<?= $rs2['variedad']?>">&nbsp;&nbsp;&nbsp;<?= $rs2['variedad']." - ".$rs2['presentacion']." (".$rs2['unidades']."x".$rs2['volumen'].")"?></td>
								<?	
								$precio = $rs3['precio'];
								if($tipo == 1) $precio_visible = $precio;
								if($tipo == 2) $precio_visible = ($precio / 1.21);
								if($tipo == 2) $resto = ($precio - $precio_visible);
								$precio_visible = number_format($precio_visible, 2, '.', ',');
								?>			
								<td class="data" align="center" title="Precio de <?= $lista." (".$rs2['variedad'].")"?>"><?= $precio_visible?></td>
							</tr>
							<tr height="1"><td bgcolor="#333333" colspan="2"></td></tr>
						<? }?>
					<? }?>
					<tr height="20"><td></td></tr>
				</table>
			<?
			}else{ // todas las listas
				$q = query("SELECT * FROM listas ORDER BY sigla");
				$cant = mysql_num_rows($q);
				if($cant > 0){	
					$id_listas = array();
					$listas = array();
					$siglas = array();
					$r = 0;
					while($rs = mysql_fetch_array($q)){
						$id_listas[$r] = $rs['id_lista']; 
						$listas[$r] = $rs['lista']; 
						$siglas[$r] = $rs['sigla']; 
						$r++;
					}
					?>
					<table width="800" align="center" cellpadding="0" cellspacing="1">
						<?
						$q1 = query("SELECT p.id_categoria, categoria, p.id_linea, linea FROM productos p
									INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
									INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
									GROUP BY linea
									ORDER BY p.orden");
						while($rs1 = mysql_fetch_array($q1)){
							$id_categoria = $rs1['id_categoria'];
							$id_linea = $rs1['id_linea'];
							$categoria = $rs1['categoria'];
							$linea = $rs1['linea'];
							?>
							<tr height="40">
								<td class="dataBold" bgcolor="#999999">&nbsp;&nbsp;&nbsp;<?= $categoria." ".$linea?></td>
								<?	for($i = 0; $i < $cant; $i++){?>
									<td width="70" align="center" title="<?= $listas[$i]?>" bgcolor="#999999" class="dataBold"><?= $siglas[$i]?></td>
								<? }?>
							</tr>
							<?
							$q2 = query("SELECT id_producto, variedad, sigla, presentacion, unidades, volumen FROM productos p
										INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
										INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
										WHERE p.id_categoria = $id_categoria AND p.id_linea = $id_linea
										ORDER BY p.orden");
							while($rs2 = mysql_fetch_array($q2)){
								$c = $flag ? "c1":"c2";
								$flag =! $flag;	
								$id_producto = $rs2['id_producto'];
								?>
								<tr height="40">
									<td class="data" title="<?= $rs2['variedad']?>">&nbsp;&nbsp;&nbsp;<?= $rs2['sigla']." - ".$rs2['presentacion']." (".$rs2['unidades']."x".$rs2['volumen'].")"?></td>
									<?	
									for($i=0; $i < $cant; $i++){
										$id_lista = $id_listas[$i];
										$q3 = query("SELECT precio FROM precios WHERE id_producto = $id_producto AND id_lista = $id_lista  AND fecha= '$fecha'");
										$rs3 = mysql_fetch_array($q3);
										$precio = $rs3['precio'];
										if($tipo == 1) $precio_visible = $precio;
										if($tipo == 2) $precio_visible = ($precio / 1.21);
										if($tipo == 2) $resto = ($precio - $precio_visible);
										$precio_visible = number_format($precio_visible, 2, '.', ',');
										?>			
										<td class="data" align="center" title="Precio de <?= $listas[$i]." (".$rs2['variedad'].")"?>"><?= $precio_visible?></td>
									<? }?>
								</tr>
							<? }?>
						<? }?>
						<tr height="20"><td></td></tr>
					</table>
				<? }?>
			<? }?>
		</td>
	</tr>
</table>
</body>
</html>
