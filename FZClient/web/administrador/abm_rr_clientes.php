<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];

if($mes == "" && $ano == "") $ano = date("Y");
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

<p align="center" class="titulo">ACORDES - RESUMEN</p>

<br>
<?
	$id_p = $_REQUEST['id_p'];
	$id_tipo = $_REQUEST['id_tipo'];
	$id_categoria = $_REQUEST['id_categoria'];
	$id_v = $_REQUEST['id_v'];
	$id_grupo = $_REQUEST['id_grupo'];
?>
<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="form">
	<input type="hidden" name="id_tipo" value="<?= $id_tipo?>">
	<input type="hidden" name="id_categoria" value="<?= $id_categoria?>">
	<input type="hidden" name="id_vendedor" value="<?= $id_vendedor?>">
	<table width="500" cellpadding="0" cellspacing="0" border="0" align="center">
		<tr height="30">
			<td width="45%" class="titulo" align="right">Producto</td>
			<td width="5%">&nbsp;</td>
			<td width="50%">
				<select name="id_p" onChange="vbscript:form.submit">
					<option value="">Seleccione el tipo de producto</option>
						<option value="1" <?= $id_p == 1 ? "SELECTED" : "" ?>>Productos en Cajas</option>
						<option value="2" <?= $id_p == 2 ? "SELECTED" : "" ?>>Productos en Botella</option>
						<option value="3" <?= $id_p == 3 ? "SELECTED" : "" ?>>Otros Productos</option>
						<option value="9" <?= $id_p == 9 ? "SELECTED" : "" ?>>Cantidad Equivalente</option>
				</select>
			</td>
		</tr>
		<tr height="30">
			<td width="45%" class="titulo" align="right">Tipo de Clientes</td>
			<td width="5%">&nbsp;</td>
			<td width="50%">
				<select name="id_tipo" onChange="vbscript:form.submit">
					<option value="">Seleccione el tipo de cliente</option>
					<? $q_t = query("SELECT * FROM tipo_clientes order by tipo");
					while($rs_t=mysql_fetch_array($q_t)){ ?>
						<option value="<?=$rs_t['id_tipo']?>" <? echo ($rs_t['id_tipo']==$id_tipo)?"SELECTED":""?>><?=$rs_t['tipo']?></option>
					<? }?>
				</select>
			</td>
		</tr>
		<tr height="30">
			<td class="titulo" align="right">Categorias</td>
			<td>&nbsp;</td>
			<td>
				<select name="id_categoria" onChange="vbscript:form.submit">
					<option value="">Seleccione la categoria del cliente</option>
					<? $q_t=query("SELECT * FROM categoria_clientes order by categoria");
						while($rs_t=mysql_fetch_array($q_t)){ ?>
					<option value="<?=$rs_t['id_categoria']?>" <? echo ($rs_t['id_categoria']==$id_categoria)?"SELECTED":""?>><?=$rs_t['categoria']?></option>
					<? }?>
				</select>
			</td>
		</tr>
		<?
		if($_SESSION['admin'] == "ok"){
		?>
			<tr height="30">
				<td class="titulo" align="right">Vendedores</td>
				<td>&nbsp;</td>
				<td>
					<select name="id_v" onChange="vbscript:form.submit">
						<option value="">Seleccione un vendedor</option>
						<?
						$q_v = query("SELECT nombre, id_vendedor FROM vendedores ORDER BY nombre");
						while($rs_v = mysql_fetch_array($q_v)){
							$nombre_v = $rs_v['nombre'];
							$nombre_v = substr($nombre_v, 0, 25);
						?>
						<option value="<?=$rs_v['id_vendedor']?>" <?= $id_v == $rs_v['id_vendedor'] ? " SELECTED" : "" ?>><?= $nombre_v?></option>
						<? }?>
					</select>
				</td>
			</tr>
		<? }?>
        <tr>
			<td class="titulo" align="right">Grupo</td>
            <td>&nbsp;</td>
			<td>
            <? $q = query("SELECT * FROM grupos ORDER BY grupo");?>
			<select name="id_grupo" onChange="javascript:form.submit();">
				<option value="">Todos</option>
				  <? while ($rs = mysql_fetch_array($q)){?>
					<option value="<?=$rs['id_grupo']?>" <? if ($_REQUEST['id_grupo'] == $rs['id_grupo']){echo " SELECTED";} ?>><?=$rs['grupo']?></option>
				  <? }?>	
			</select>
			</td>
		</tr>
	</table>
</form>
<?
if($_SESSION['admin'] != "ok") $id_v = $_SESSION['id_vendedor'];	

	if($id_tipo != "" OR $id_categoria != "" OR $id_v != "" OR $id_grupo != "") $w = "WHERE ";
	if($id_tipo != "") $id_t = "c.id_tipo= ".$id_tipo. " AND ";
	if($id_categoria != "") $id_c = "c.id_categoria= ".$id_categoria. " AND ";
	if($id_v != "") $id_ve = "c.id_vendedor= ".$id_v. " AND ";
	if($id_grupo != "") $id_g = "g.id_grupo=" . $id_grupo. " AND ";

	$where = $w ."". $id_t ."". $id_c ."". $id_ve ."". $id_g;
	$where = substr($where, 0, strlen($where) - 5);
?>
<table width="90%" cellpadding="0" cellspacing="0" border="0">
	<tr height="50">
		<td align="center" width="50%">&nbsp;</td>
		<td align="right" width="50%"><a href="imp_rr_clientes.php?id_p=<?= $id_p?>&id_tipo=<?= $id_tipo?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>" target="_blank"><img src="images/b_print.png" border="0"> &nbsp;Imprimir el reporte</a></td>
	</tr>
</table>
<?
$anos = array();
$i = 0;
$a = query("SELECT year(fecha) AS ano FROM ventas WHERE year(fecha) <> '' GROUP BY ano DESC LIMIT 6");
while($rs = mysql_fetch_array($a)){
	$anos[$i] = $rs['ano'];
	$i++;
}
$anos = array_reverse($anos); 
?>

<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="t" width="30%">&nbsp;&nbsp;Cliente</td>
		<td class="t" width="10%" align="center">Catg</td>
		<td class="t" width="10%" align="center">Vend</td>
			<? foreach($anos as $ano){ ?>
				<td class="t" width="5%" align="center"><?= $ano?></td>
			<? }?>
		<td class="t" width="10%" align="center">TOTAL</td>
	</tr>
	<?	
	$qc = query("SELECT c.id_cliente, c.apellido, c.nombre, cc.sigla AS sigla_cat, ve.sigla AS sigla_vend 
				FROM clientes c
				INNER JOIN ventas v ON v.id_cliente = c.id_cliente
				LEFT JOIN vendedores ve ON ve.id_vendedor = c.id_vendedor
				LEFT JOIN categoria_clientes cc ON cc.id_categoria = c.id_categoria
				LEFT JOIN grupos g on g.id_grupo = c.id_grupo
				$where
				GROUP BY c.id_cliente ORDER BY apellido, nombre");
	$c_T = 0;
	if($id_p == 1) $andP = "AND presentacion LIKE '%caja%'";
	if($id_p == 2) $andP = "AND presentacion LIKE '%botella%'";
	if($id_p == 3) $andP = "AND presentacion NOT LIKE '%caja%' AND presentacion NOT LIKE '%botella%'";
	while($rc = mysql_fetch_array($qc)){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		
		$id_cliente = $rc['id_cliente'];
		$cliente = $rc['apellido'];
		$nombre = $rc['nombre'];
		if($nombre != "") $cliente = $cliente.", ".$nombre;
		$categoria = $rc['sigla_cat'];
		$vendedor = $rc['sigla_vend'];
		?>
		<tr height="30">
			<td class="<?= $c?>">&nbsp;&nbsp;<?= $cliente?></td>
			<td class="<?= $c?>" align="center"><?= $categoria?></td>
			<td class="<?= $c?>" align="center"><?= $vendedor?></td>
			<? 
			$a = 0;	
			$c_T = 0;
			foreach($anos as $ano){
				$sql = "SELECT SUM(vd.cant) AS cant, SUM(vd.cant * p.ue) AS cant_eq FROM ventas_detalle vd
						INNER JOIN ventas v ON v.id_venta = vd.id_venta
						LEFT JOIN productos p ON p.id_producto = vd.id_producto
						LEFT JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE YEAR(v.fecha) = $ano AND v.id_cliente= $id_cliente $andP";
				//echo ($sql."<br><br>");
				$q = query($sql);
				$rs = mysql_fetch_array($q);
				$cant = $rs['cant'];
				if($id_p == 9) $cant = $rs['cant_eq'];
				if($cant == "") $cant = 0;
				?><td class="<?= $c?>" align="center"><?= number_format($cant, 0, ',','.')?></td><? 
				$c_T += $cant;
				$ano_T[$a] += $cant;
				$total += $cant;
				$a++;
				?>
			<? }?>
			<td class="<?= $c?>" align="center"><?= number_format($c_T, 0, ',','.')?></td>
		</tr>
		<? 
		$reg++;
	}
	?>
	<tr height="30">
		<td class="t">&nbsp;&nbsp;TOTAL: &nbsp;&nbsp;<?= $reg?> Registros</td>
		<td class="t" colspan="2" align="center"></td>
		<? 	
		$a = 0;
		foreach($anos as $ano){?>
			<td class="t" align="center"><?= number_format($ano_T[$a], 0, ',','.')?></td>
			<? $a++;?>
		<? }?>
		<td class="t" align="center"><?= number_format($total, 0, ',','.')?></td>
	</tr>
</table>
<br>




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
