<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$ver = $_REQUEST['ver'];
if($ver == "") $ver = "listar";

$id_cotizacion = $_REQUEST["id_cotizacion"];
$id_insumo = $_REQUEST["id_insumo"];
$id_proveedor = $_REQUEST["id_proveedor"];
$costo = $_REQUEST["costo"];
$unidad = $_REQUEST["unidad"];

$fecha = $_REQUEST['fecha'];
list($dia, $mes, $ano) = split( '[/.-]', $fecha);
$fecha = $ano."-".$mes."-".$dia;

$detalle = $_REQUEST["detalle"];

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["agregar"] == "ok"){
	if($id_insumo != "" and id_proveedor != ""){
		$sql =  "INSERT INTO cotizaciones VALUES (null, $id_insumo, $id_proveedor, $costo, $unidad, '$fecha', '$detalle')";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La cotizacion se agrego correctamente</font>";
	}
	else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>Debe seleccionar todos los datos.</font>";
	}
}
if ($_REQUEST['modificar'] == "ok"){
	$sql = "UPDATE cotizaciones SET id_insumo= $id_insumo, id_proveedor= $id_proveedor, costo= $costo, unidad= $unidad, fecha= '$fecha', detalle= '$detalle' WHERE id_cotizacion = $id_cotizacion";
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La cotizacion se modifico correctamente</font>";
}
if ( $_REQUEST["modificar_o"] == "ok" ){
	$cant = $_REQUEST['Q'];
	for($i = 0; $i < $cant; $i++){
		$sql1 = "UPDATE cotizaciones SET orden= ". $_REQUEST["orden_".$i] ." WHERE id_cotizacion = ". $_REQUEST["id_cotizacion_".$i];
		if($insertar == "ok") mysql_query($sql1, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql1."<br>");
	}
	$txt = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El orden se modifico correctamente</font>";
	unset($modificar_o); 
}
if ($_REQUEST["borrar"]=='ok'){
	$id_insumo = $_REQUEST['id_insumo'];
	$sql = "DELETE FROM cotizaciones where id_insumo = $id_insumo";
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La cotizacion se elimino correctamente</font>";		
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
function confirmarA(){
		return confirm("Estás seguro que queres agregar este insumo?");
}
function confirmarM(){
		return confirm("Estás seguro que queres modificar este insumo?");
}
function confirmarE(){
		return confirm("Estás seguro que queres eliminar este insumo?");
}
function confirmarO(){
		return confirm("Estás seguro que queres modificar el orden de los servicios?");
}
var newwindow;
function popup(url)
{
	newwindow=window.open(url,'name','width=450, height=150');
	if (window.focus) {newwindow.focus()}
}

</SCRIPT>
<script language="javascript" src="calendar1.js"></script>
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

<p align="center" class="titulo"><strong>Cotizaciones</strong></p>
<br>
<p class="error" align="center"><?=$msg?></p>
<?
if($ver != "listar"){
?>
	<table width="500" align="center" cellpadding="0" cellspacing="1">
		<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="formu">
			<?	if($id_cotizacion == ""){?>
			  <input type="hidden" name="agregar" value="ok">
			  <tr height="30"><td class="t" colspan="4" align="center">Agregar una cotizacion</td></tr>
			<?	
				} 
				else{ 
					$q2 = query("SELECT * FROM cotizaciones WHERE id_cotizacion = $id_cotizacion");
					$rs2 = mysql_fetch_array($q2);
					$id_insumo = $rs2['id_insumo'];
					$id_proveedor = $rs2['id_proveedor'];
					$costo = $rs2['costo'];
					$unidad = $rs2['unidad'];
					$detalle = $rs2['detalle'];
					$fecha = $rs2['fecha'];
					list($ano, $mes, $dia) = split( '[/.-]', $fecha);
					$fecha = $dia."-".$mes."-".$ano;
			?>
			  <input type="hidden" name="id_cotizacion" value="<?= $id_cotizacion?>">
			  <input type="hidden" name="modificar" value="ok">
			  <tr height="30"><td class="t" colspan="4" align="center">Modificar una cotizacion</td></tr>
		 	<? }?>
			<?
			if($fecha == "" || $fecha == "--") $fecha = date(d."-".m."-".Y);
			?>
			<tr height="30">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Insumos</td>
				<td width="500" class="c1">&nbsp;&nbsp;
					<select name="id_insumo">
						<option value="">Seleccionar el insumo</option>
						<option value="">----------------------------------</option>
						<? 
						$q_c = query("SELECT * FROM insumos ORDER BY insumo");
						while($rs_c = mysql_fetch_array($q_c)){ 
						?>
						<option value="<?= $rs_c['id_insumo']?>" <? echo ($id_insumo == $rs_c['id_insumo'])?" SELECTED":""; ?> ><?= $rs_c['insumo']?></option>
						<? }?>
					</select>
				</td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2" align="center">Proveedores</td>
				<td width="500" class="c2">&nbsp;&nbsp;
					<select name="id_proveedor">
						<option value="">Seleccionar al proveedor</option>
						<option value="">----------------------------------</option>
						<? 
						$q_c = query("SELECT * FROM proveedores ORDER BY empresa");
						while($rs_c = mysql_fetch_array($q_c)){ 
						?>
						<option value="<?= $rs_c['id_proveedor']?>" <? echo ($id_proveedor == $rs_c['id_proveedor'])?" SELECTED":""; ?> ><?= $rs_c['empresa']?></option>
						<? }?>
					</select>
				</td>
				<td width="25" class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Costo</td>
				<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="costo" value="<?= $costo?>" size="8"></td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Unidad</td>
				<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="unidad" value="<?= $unidad?>" size="8"></td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Fecha</td>
				<td width="500" class="c1">&nbsp;&nbsp;<input name="fecha" type="text" size="10" value="<?= $fecha?>">&nbsp;<img src="images/cal.gif" onClick="javascript:call.popup();"></td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="120">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Detalle</td>
				<td width="500" class="c1">&nbsp;&nbsp;<textarea name="detalle" rows="7" cols="50"><?= $detalle?></textarea></td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<?	if($id_insumo == ""){?>
		  			<tr height="50">
						<td colspan="4" width="100%" class="t" align="center">
							<input type="image" name="enviar2" src="images/b_insert.png" alt="Agregar el Insumo" onClick="return confirmarA();">&nbsp;&nbsp;
							<a href="<?= $_SERVER['PHP_SELF']?>?ver=listar"><img src="images/b_back.png" width="30" height="30" border="0" alt="Volver"></a>
						</td>
					</tr>
			<?	} else{ ?>
		  			<tr height="50">
						<td colspan="4" width="100%" class="t" align="center">
							<input type="image" name="enviar3" src="images/b_insert.png" alt="Modificar el Insumo" onClick="return confirmarM();">&nbsp;&nbsp;
							<a href="<?= $_SERVER['PHP_SELF']?>?ver=listar"><img src="images/b_back.png" width="30" height="30" border="0" alt="Volver"></a>
						</td>
					</tr>
		 	<? }?>
		</form>
	</table>
	<script language="javascript">
		var call = new calendar1(document.forms['formu'].elements['fecha']);
			call.year_scroll = true;
			call.time_comp = false;
	</script>
<?
}
else{
?>
	<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="formu" onSubmit="return confirmarO();">
		<input type="hidden" name="modificar_o" value="ok">
		<table width="900" align="center" cellpadding="0" cellspacing="0">
			<tr height="35">
				<td colspan="4">&nbsp;</td>
				<td colspan="4" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?ver=insert"><img src="images/b_insert_new.png" border="0" alt="Insertar una nueva presentacion"></a></td>
			</tr>
			<tr height="30">
				<td width="2%" class="t">&nbsp;</td>
				<td width="35%" class="t"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=insumo" title="Ordenar x Insumo">Insumo</a></td>
				<td width="20%" class="t"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=proveedor" title="Ordenar x Proveedor">Proveedor</a></td>
				<td width="13%" class="t" align="center"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=costo" title="Ordenar x Costo">Costo</a></td>
				<td width="5%" class="t" align="center"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&unidades=costo" title="Ordenar x Unidades">Unidades</a></td>
				<td width="13%" class="t" align="center"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=fecha" title="Ordenar x Fecha">Fecha</a></td>
				<td width="10%" class="t">&nbsp;</td>
				<td width="2%" class="t">&nbsp;</td>
			</tr>
			<tr height="1"><td></td></tr>
			<?
			$order = $_REQUEST['order'];
			if($order == "") $order = "insumo";
			$q = query("SELECT id_cotizacion, insumo, empresa, costo, unidad, fecha FROM cotizaciones c
						INNER JOIN insumos i ON i.id_insumo = c.id_insumo
						INNER JOIN proveedores p ON p.id_proveedor = c.id_proveedor
						ORDER BY $order");
			if(mysql_num_rows($q)>0){
				$t = 0;
				while($rs = mysql_fetch_array($q)){
					$c = $flag ? "c1":"c2";
					$flag =! $flag;	
					$id_cotizacion = $rs['id_cotizacion'];
					$insumo = $rs['insumo'];
					$empresa = $rs['empresa'];
					$costo = $rs['costo'];
					$unidad = $rs['unidad'];
					$fecha = $rs['fecha'];
					list($ano, $mes, $dia) = split( '[/.-]', $fecha);
					$fecha = $dia."-".$mes."-".$ano;
				?>
					<input type="hidden" name="id_insumo_<?= $t?>" value="<?= $id_insumo?>">
					<tr height="40" valign="middle">
						<td class="<?= $c?>">&nbsp;</td>
						<td class="<?= $c?>"><?= $insumo?></td>
						<td class="<?= $c?>"><?= $empresa?></td>
						<td class="<?= $c?>" align="center">$&nbsp;<?= number_format($costo, 2, ".", ",")?></td>
						<td class="<?= $c?>" align="center"><?= number_format($unidad, 0, ".", ",")?></td>
						<td class="<?= $c?>" align="center"><?= $fecha?></td>
						<td class="<?= $c?>" align="center">
							<a href="<?= $_SERVER['PHP_SELF']?>?id_cotizacion=<?= $id_cotizacion?>&ver=modificar"><img src="images/b_save.png" border="0" alt="Editar la cotizacion"></a>&nbsp;&nbsp;
							<a href="<?= $_SERVER['PHP_SELF']?>?borrar=ok&id_insumo=<?= $rs['id_insumo']?>" onClick="return confirmarE();"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar este insumo"></a>
						</td>
						<td class="<?= $c?>">&nbsp;</td>
					</tr>
				<? 
					$t++;	
				}
			}else{
				?>
				<tr height="60" valign="middle">
					<td class="c1" colspan="8" align="center">No hay ninguna cotizacion cargada</td>
				</tr>
				<?
			}
			?>
			<input type="hidden" name="Q" value="<?= $t?>">
			<tr height="15"><td colspan="8" class="t"></td></tr>
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
