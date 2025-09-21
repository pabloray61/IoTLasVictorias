<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$lista = $_REQUEST["lista"];
$tipo = $_REQUEST['tipo'];
$fecha = $_REQUEST['fecha'];

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["guardar"] == "ok"){
	$fecha = date("Y-m-d");
	$qE = "DELETE FROM precios WHERE fecha='$fecha'";
	if($insertar == "ok") mysql_query($qE, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$qE."<br>");

	$q1 = query("SELECT id_producto FROM productos");
	while($rs1 = mysql_fetch_array($q1)){
		$q2 = query("SELECT id_lista FROM listas");
		while($rs2 = mysql_fetch_array($q2)){
			$id_producto = $rs1['id_producto'];
			$id_lista = $rs2['id_lista'];
			$cod = $id_producto.'_'.$id_lista;
			if($tipo == 1) $precio = $_REQUEST["precio_".$cod];
			if($tipo == 2) $precio = $_REQUEST["precio_".$cod] + $_REQUEST["resto_".$cod];
			if($precio == "") $precio = 0;
			if($precio != 0){
				$sql =  "INSERT INTO precios VALUES (null, $id_producto, $id_lista, '$precio', '$fecha')";
				if($insertar == "ok") mysql_query($sql, $conn_id);
				if($imprimir == "ok") echo("SQL: ".$sql."<br>");
			}
		}
	}
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La precios se actualizaron correctamente</font>";
}

?>

<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<SCRIPT LANGUAGE="JavaScript">
function confirmarg(){
		return confirm("Estás seguro que queres guardar los precios?");
}
</SCRIPT>
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

<p align="center" class="titulo"><strong>Listas de precios</strong></p>
<br>
<p class="error" align="center"><?=$msg?></p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<form method="post" name="filtro" action="<?=$_SERVER['PHP_SELF']?>">
		<tr height="40">
			<td align="right" width="40%">
				<select name="tipo" onChange="filtro.submit();">
					<option value="1" <? if($tipo == 1) echo('SELECTED')?>>Precios con Iva</option>
					<option value="2" <? if($tipo == 2) echo('SELECTED')?>>Precios sin Iva</option>
				</select>
			</td>
			<td width="20%">&nbsp;</td>
			<td align="left" width="40%">
				<select name="fecha" onChange="filtro.submit();">
				<?
					$qf = query("SELECT fecha FROM precios GROUP BY fecha DESC");
					while($rsf = mysql_fetch_array($qf)){
						list($ano, $mes, $dia) = split( '[/.-]', $rsf['fecha']);
						$fec = $dia."-".$mes."-".$ano;
						?>
						<option value="<?= $rsf['fecha']?>" <? if($rsf['fecha'] == $fecha) echo('SELECTED')?>><?= $fec?></option>
					<? }?>
				</select>
			</td>
		</tr>
	</form>	
</table>
<?
if($fecha == ""){
	$qf = query("SELECT fecha FROM precios GROUP BY fecha DESC");
	$rsf = mysql_fetch_array($qf);
	$fecha = $rsf['fecha'];
}
if($tipo == "") $tipo = 1;
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
	<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="formu" onSubmit="return confirmarG();">
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
					<td class="t">&nbsp;&nbsp;&nbsp;<?= $categoria." ".$linea?></td>
					<?	for($i = 0; $i < $cant; $i++){?>
						<td width="70" class="t" align="center" title="<?= $listas[$i]?>"><?= $siglas[$i]?></td>
					<? }?>
				</tr>
					<?
					$q2 = query("SELECT id_producto, variedad, sigla, presentacion, unidades, volumen FROM productos p
								INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
								INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
								WHERE p.id_categoria = $id_categoria AND p.id_linea = $id_linea
								ORDER BY p.orden
								");
					while($rs2 = mysql_fetch_array($q2)){
						$c = $flag ? "c1":"c2";
						$flag =! $flag;	
						$id_producto = $rs2['id_producto'];
					?>
						<tr height="40">
							<td class="<?= $c?>" title="<?= $rs2['variedad']?>">&nbsp;&nbsp;&nbsp;<?= $rs2['sigla']." - ".$rs2['presentacion']." (".$rs2['unidades']."x".$rs2['volumen'].")"?></td>
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
								<td class="<?= $c?>" align="center" title="Precio de <?= $listas[$i]." (".$rs2['variedad'].")"?>"><input type="text" name="precio_<?= $id_producto?>_<?= $id_lista?>" value="<?= $precio_visible?>" size="4" style="text-align:center;" title="Precio de <?= $listas[$i]." (".$rs2['variedad'].")"?>"></td>
								<input type="hidden" name="resto_<?= $id_producto?>_<?= $id_lista?>" value="<?= $resto?>" size="4">
							<? }?>
						</tr>
					<? }?>
				<? }?>
				<input type="hidden" name="tipo" value="<?= $tipo?>">
				<input type="hidden" name="fecha" value="<?= $fecha?>">
				<input type="hidden" name="guardar" value="ok">
			<tr height="50">
				<td colspan="<?= ($cant + 1)?>" class="t">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">&nbsp;</td>
							<td width="50%" align="center"><input type="image" src="images/b_insert.png" name="guardar" title="Guardar los precios finales"></td>
							<td width="10%" align="right"><a href="imp_lista_precios.php?tipo=<?= $tipo?>&fecha=<?= $fecha?>" target="_blank" class="link_t"><img src="images/b_print.png" border="0"></a></td>
							<td width="10%" align="left">&nbsp;<a href="imp_lista_precios.php?tipo=<?= $tipo?>&fecha=<?= $fecha?>" target="_blank" class="link_t">Imprimir</a></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
<? }?>	
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
