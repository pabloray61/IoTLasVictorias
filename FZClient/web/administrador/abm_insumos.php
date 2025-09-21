<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$ver = $_REQUEST['ver'];
if($ver == "") $ver = "listar";

$id_insumo = $_REQUEST["id_insumo"];
$id_categoria = $_REQUEST["id_categoria"];
$insumo = $_REQUEST["insumo"];
$detalle = $_REQUEST["detalle"];
$especificacion = $_REQUEST["especificacion"];

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["agregar"] == "ok"){
	if($id_categoria != "" and id_producto != ""){
		$sql =  "INSERT INTO insumos VALUES (null, $id_categoria, '$insumo', '$detalle', '$especificacion', NULL)";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El insumo se agrego correctamente</font>";
	}
	else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>Debe seleccionar todos los datos del insumo.</font>";
	}
}
if ($_REQUEST['modificar'] == "ok"){
	$sql = "UPDATE insumos SET id_categoria= $id_categoria, insumo= '$insumo', detalle= '$detalle', especificacion= '$especificacion' WHERE id_insumo = $id_insumo";
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El insumo se modifico correctamente</font>";
}
if ( $_REQUEST["modificar_o"] == "ok" ){
	$cant = $_REQUEST['Q'];
	for($i = 0; $i < $cant; $i++){
		$sql1 = "UPDATE insumos SET orden= ". $_REQUEST["orden_".$i] ." WHERE id_insumo = ". $_REQUEST["id_insumo_".$i];
		if($insertar == "ok") mysql_query($sql1, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql1."<br>");
	}
	$txt = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El orden se modifico correctamente</font>";
	unset($modificar_o); 
}
if ($_REQUEST["borrar"]=='ok'){
	$id_insumo = $_REQUEST['id_insumo'];
	$sql = "DELETE FROM insumos where id_insumo = $id_insumo";
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El insumo se elimino correctamente</font>";		
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

<p align="center" class="titulo"><strong>Insumos</strong></p>
<br>
<p class="error" align="center"><?=$msg?></p>
<?
if($ver != "listar"){
?>
	<table width="500" align="center" cellpadding="0" cellspacing="1">
		<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="formu">
			<?	if($id_insumo == ""){?>
			  <input type="hidden" name="agregar" value="ok">
			  <tr height="30"><td class="t" colspan="4" align="center">Agregar un Insumo</td></tr>
			<?	
				} 
				else{ 
					$q2 = query("SELECT * FROM insumos WHERE id_insumo = $id_insumo");
					$rs2 = mysql_fetch_array($q2);
					$id_categoria = $rs2['id_categoria'];
					$insumo = $rs2['insumo'];
					$detalle = $rs2['detalle'];
					$especificacion = $rs2['especificacion'];
			?>
			  <input type="hidden" name="id_insumo" value="<?= $id_insumo?>">
			  <input type="hidden" name="modificar" value="ok">
			  <tr height="30"><td class="t" colspan="4" align="center">Modificar el Insumo</td></tr>
		 	<? }?>
			<tr height="30">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2" align="center">Categoria</td>
				<td width="500" class="c2">&nbsp;&nbsp;
					<select name="id_categoria">
						<option value="">Seleccionar la categoria</option>
						<option value="">----------------------------------</option>
						<? 
						$q_c = query("SELECT * FROM i_categorias ORDER BY categoria");
						while($rs_c = mysql_fetch_array($q_c)){ 
						?>
						<option value="<?= $rs_c['id_categoria']?>" <? echo ($id_categoria == $rs_c['id_categoria'])?" SELECTED":""; ?> ><?= $rs_c['categoria']?></option>
						<? }?>
					</select>
				</td>
				<td width="25" class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Insumo</td>
				<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="insumo" value="<?= $insumo?>" size="50"></td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2" align="center">Especificacion</td>
				<td width="500" class="c2">&nbsp;&nbsp;
					<?
							$tmp = listarArchivos("../especificaciones/", "");
							echo "<Select name='especificacion'>\n";
							echo "<option value=''>Seleccione la especificacion del insumo</option>";
							echo "<option value=''>-----------------------------------</option>";
							for ($j=0; $j < count($tmp); $j++){
								if ($tmp[$j] != "Thumbs.db" && substr(strrchr($tmp[$j], '.'), 1) != "LCK"){
									$selected = $tmp[$j] == $especificacion ? "SELECTED":"";
									echo "<option value='". $tmp[$j] ."' $selected >". $tmp[$j] ."</option>\n";
								}
							}
							echo "</select>";
						?>&nbsp;&nbsp;<a href="javascript:popup('uploader_file.php?seccion=especificaciones');"><img src="images/b_import.png" border="0" alt="Cargar una especificacion"></a>
				</td>
				<td width="25" class="c2">&nbsp;</td>
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
<?
}
else{
?>
	<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="formu" onSubmit="return confirmarO();">
		<input type="hidden" name="modificar_o" value="ok">
		<table width="900" align="center" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="3"><input name="enviar3" type="image" src="images/b_insert.png" alt="Guardar el nuevo orden" align="middle" width="25"></td>
				<td colspan="3" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?ver=insert"><img src="images/b_insert_new.png" border="0" alt="Insertar una nueva presentacion"></a></td>
			</tr>
			<tr height="30">
				<td width="2%" class="t">&nbsp;</td>
				<td width="6%" class="t" align="center"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=orden" title="Ordenar x orden">Orden</a></td>
				<td width="15%" class="t">&nbsp;&nbsp;<a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=categoria" title="Ordenar x Categoria">Categoria</a></td>
				<td width="40%" class="t" align="center"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=insumo" title="Ordenar x Insumo">Insumo</a></td>
				<td width="25%" class="t" align="center"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=especificacion" title="Agrupar x especificacion">Especificacion</a></td>
				<td width="10%" class="t">&nbsp;</td>
				<td width="2%" class="t">&nbsp;</td>
			</tr>
			<tr height="1"><td></td></tr>
			<?
			$order = $_REQUEST['order'];
			if($order == "") $order = "orden";
			$q = query("SELECT id_insumo, ic.categoria, orden, insumo, especificacion FROM insumos i
						INNER JOIN i_categorias ic ON ic.id_categoria = i.id_categoria
						ORDER BY $order");
			if(mysql_num_rows($q)>0){
				$t = 0;
				while($rs = mysql_fetch_array($q)){
					$c = $flag ? "c1":"c2";
					$flag =! $flag;	
					$id_insumo = $rs['id_insumo'];
					$orden = $rs['orden'];
					$categoria = $rs['categoria'];
					$insumo = $rs['insumo'];
					$especificacion = $rs['especificacion'];
					if($especificacion != "") $file = "<a href='../especificaciones/$especificacion' target='_blank' title='Ver la especificacion'><img src='images/b_factura.png' border='0'></a>";
				?>
					<input type="hidden" name="id_insumo_<?= $t?>" value="<?= $id_insumo?>">
					<tr height="40" valign="middle">
						<td class="<?= $c?>">&nbsp;</td>
						<td class="<?= $c?>" align="center"><input name="orden_<?= $t?>" type="text" value="<?= $orden?>" size="1" style="text-align:center;"></td>
						<td class="<?= $c?>">&nbsp;&nbsp;<?= $categoria?></td>
						<td class="<?= $c?>" align="center"><?= $insumo?></td>
						<td class="<?= $c?>" align="center"><?= $file?></td>
						<td class="<?= $c?>" align="center">
							<a href="<?= $_SERVER['PHP_SELF']?>?id_insumo=<?= $id_insumo?>&ver=modificar"><img src="images/b_save.png" border="0" alt="Editar el insumo"></a>&nbsp;&nbsp;
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
					<td class="c1" colspan="7" align="center">No hay ningun insumo cargado</td>
				</tr>
				<?
			}
			?>
			<input type="hidden" name="Q" value="<?= $t?>">
			<tr height="15"><td colspan="7" class="t"></td></tr>
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
