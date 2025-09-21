<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$id_linea = $_REQUEST['id_linea'];

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["guardar"] == "ok"){
	$fecha = date("Y-m-d");
	$qE = "DELETE FROM i_producto WHERE id_linea = $id_linea";
	if($insertar == "ok") mysql_query($qE, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$qE."<br>");
	$q1 = query("SELECT id_producto FROM productos WHERE id_linea= $id_linea");
	while($rs1 = mysql_fetch_array($q1)){
		$q2 = query("SELECT id_insumo FROM insumos");
		while($rs2 = mysql_fetch_array($q2)){
			$id_producto = $rs1['id_producto'];
			$id_insumo = $rs2['id_insumo'];
			$cod = $id_insumo.'_'.$id_producto;
			$cantidad = $_REQUEST["cantidad_".$cod];
			if($cantidad == "") $cantidad = 0;
			if($cantidad != 0){
				$sql =  "INSERT INTO i_producto VALUES (null, $id_insumo, $id_producto, $id_linea, $cantidad)";
				if($insertar == "ok") mysql_query($sql, $conn_id);
				if($imprimir == "ok") echo("SQL: ".$sql."<br>");
			}
		}
	}
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>Los valores se actualizaron correctamente</font>";
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
		return confirm("Estás seguro que queres guardar estos datos?");
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

<p align="center" class="titulo"><strong>INSUMOS - PRODUCTO</strong></p>
<br>
<p class="error" align="center"><?=$msg?></p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<form method="post" name="filtro" action="<?=$_SERVER['PHP_SELF']?>">
		<tr height="40">
			<td align="center" width="40%">
                <select name="id_linea" onChange="javascript:filtro.submit();">
                    <option value="">Seleccione la linea</option>
                    <option value="">----------------------------------</option>
                    <? 
                    $q_l = query("SELECT p.id_linea, CONCAT(pc.categoria, ' - ', pl.linea) AS linea FROM productos p
								INNER JOIN p_categorias pc ON p.id_categoria = pc.id_categoria
								INNER JOIN p_lineas pl ON p.id_linea = pl.id_linea
								GROUP BY p.id_linea");
                    while($rs_l = mysql_fetch_array($q_l)){ 
                    ?>
                    	<option value="<?= $rs_l['id_linea']?>" <? echo ($id_linea == $rs_l['id_linea'])?" SELECTED":""; ?> ><?= $rs_l['linea']?></option>
                    <? }?>
                </select>
			</td>
		</tr>
	</form>	
</table>
<?
if(!empty($id_linea)){
	$q = query("SELECT p.id_producto, pv.variedad, pv.sigla, pp.presentacion, pp.unidades, pp.volumen FROM productos p
				INNER JOIN p_variedades pv ON p.id_variedad = pv.id_variedad
				INNER JOIN p_presentacion pp ON p.id_presentacion = pp.id_presentacion
				WHERE id_linea = $id_linea");
	$cant = mysql_num_rows($q);
	if($cant > 0){	
		$id_producto = array();
		$producto = array();
		$siglas = array();
		$r = 0;
		while($rs = mysql_fetch_array($q)){
			$id_producto[$r] = $rs['id_producto']; 
				$variedad = $rs['variedad'];
				$sigla = $rs['sigla'];
				$presentacion = $rs['presentacion'];
				$unidades = $rs['unidades'];
				$volumen = $rs['volumen'];
				if(!empty($unidades) || !empty($volumen)){
					if(!empty($volumen)) $uv = "(".$unidades."x".$volumen.")";
					if(empty($volumen)) $uv = "(".$unidades.")";
				}
				$p = $variedad." - ".$presentacion." ".$uv;
				$s = $sigla."<br>".$presentacion."<br>".$uv;
			$producto[$r] = $p; 
			$siglas[$r] = $s;
			$r++;
		}
		?>
		<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="formu" onSubmit="return confirmarG();">
			<table width="98%" align="center" cellpadding="0" cellspacing="1">
				<?
				$q1 = query("SELECT id_insumo, i.id_categoria, ic.categoria FROM insumos i
							INNER JOIN i_categorias ic ON ic.id_categoria = i.id_categoria
							GROUP BY categoria
							ORDER BY orden");
				while($rs1 = mysql_fetch_array($q1)){
					$id_insumo = $rs1['id_insumo'];
					$id_categoria = $rs1['id_categoria'];
					$categoria = $rs1['categoria'];
				?>
					<tr height="70">
						<td width="30%" class="t">&nbsp;&nbsp;&nbsp;<?= $categoria?></td>
						<?	for($i = 0; $i < $cant; $i++){?>
							<td width="5%" class="t" align="center" title="<?= $listas[$i]?>"><?= $siglas[$i]?></td>
						<? }?>
					</tr>
						<?
						$q2 = query("SELECT i.id_insumo, i.id_categoria, ic.categoria, orden, insumo, especificacion FROM insumos i
									INNER JOIN i_categorias ic ON ic.id_categoria = i.id_categoria
									WHERE i.id_categoria = $id_categoria
									ORDER BY orden");
						while($rs2 = mysql_fetch_array($q2)){
							$c = $flag ? "c1":"c2";
							$flag =! $flag;	
							$id_insumo = $rs2['id_insumo'];
						?>
							<tr height="40">
								<td style="padding:10px 10px" class="<?= $c?>"><?= $rs2['insumo']?></td>
								<?	
								for($i=0; $i < $cant; $i++){
									$id_prod = $id_producto[$i];
									$q3 = query("SELECT cantidad FROM i_producto WHERE id_insumo = $id_insumo && id_producto = $id_prod");
									$rs3 = mysql_fetch_array($q3);
									$cantidad = $rs3['cantidad'];
									?>			
									<td class="<?= $c?>" align="center" title="<?= $producto[$i]." (".$rs2['catetegoria'].")"?>">
                                    	<input type="text" name="cantidad_<?= $id_insumo?>_<?= $id_prod?>" value="<?= $cantidad?>" size="4" style="text-align:center;" title="<?= $producto[$i]." (".$rs2['categoria'].")"?>">
                                    </td>
								<? }?>
							</tr>
						<? }?>
					<? }?>
					<input type="hidden" name="id_linea" value="<?= $id_linea?>">
					<input type="hidden" name="guardar" value="ok">
				<tr height="60">
					<td colspan="<?= ($cant + 1)?>" class="t">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%">&nbsp;</td>
								<td width="50%" align="center"><input type="image" src="images/b_insert.png" name="guardar" title="Guardar los precios finales"></td>
								<td width="10%" align="right">&nbsp;</td>
								<td width="10%" align="left">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	<? }?>	
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
