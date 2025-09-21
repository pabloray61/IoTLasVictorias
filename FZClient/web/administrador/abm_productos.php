<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$ver = $_REQUEST['ver'];
if($ver == "") $ver = "listar";

$id_producto = $_REQUEST["id_producto"];
$id_categoria = $_REQUEST["id_categoria"];
$id_linea = $_REQUEST["id_linea"];
$id_variedad = $_REQUEST["id_variedad"];
$id_presentacion = $_REQUEST["id_presentacion"];
$codigo = $_REQUEST["codigo"];
$detalle = $_REQUEST["detalle"];
$foto = $_REQUEST["foto"];
$ue = $_REQUEST["ue"];
if($ue == "") $ue = "0.00";
$venta = $_REQUEST['venta'];
$venta = empty($venta) ? 0 : 1;

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["agregar"] == "ok"){
	if($id_categoria != "" and id_linea != "" and id_variedad != "" and id_presentacion != ""){
		$q2 = query("SELECT * FROM productos WHERE id_categoria = $id_categoria AND id_linea = $id_linea AND id_variedad = $id_variedad AND id_presentacion = $id_presentacion");
		$cant = mysql_num_rows($q2);
		if ($cant == 0){		
			$sql =  "INSERT INTO productos VALUES (null, $id_categoria, $id_linea, $id_variedad, $id_presentacion, '$codigo', '$detalle', '$foto', 0, '$ue', $venta)";
			if($insertar == "ok") mysql_query($sql, $conn_id);
			if($imprimir == "ok") echo("SQL: ".$sql);
			$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El producto se agrego correctamente</font>";
		}
		else{
			$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>El producto ya se encuentra cargado</font>";
		}
	}
	else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>Debe seleccionar todos los datos del producto.</font>";
	}
}
if ($_REQUEST['modificar'] == "ok"){
	$sql = "UPDATE productos SET id_categoria = $id_categoria, id_linea = $id_linea, id_variedad = $id_variedad, 
			id_presentacion= $id_presentacion, codigo='$codigo', detalle= '$detalle', foto= '$foto', ue = '$ue', venta=$venta
			WHERE id_producto = '" . $_REQUEST['id_producto'] ."'";
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El producto se modifico correctamente</font>";
}
if ( $_REQUEST["modificar_o"] == "ok" ){
	$cant = $_REQUEST['Q'];
	for($i = 0; $i < $cant; $i++){
		$sql1 = "UPDATE productos SET orden= ". $_REQUEST["orden_".$i] .", ue= ". $_REQUEST["ue_".$i] .", venta= ". $_REQUEST["venta_".$i] ." WHERE id_producto = ". $_REQUEST["id_producto_".$i];
		if($insertar == "ok") mysql_query($sql1, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql1."<br>");
	}
	$txt = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>Los datos se modificaron correctamente</font>";
	unset($modificar_o); 
}
if ($_REQUEST["borrar"]=='ok'){

	$id_producto = $_REQUEST['id_producto'];
	
	$q = query("SELECT count(*) as cant FROM ventas_detalle WHERE id_producto = $id_producto");
	$rs = mysql_fetch_array($q);
	if ($rs['cant'] == 0){
		$sql = "DELETE FROM productos where id_producto = '" . $_REQUEST['id_producto'] . "'";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El producto se elimino correctamente</font>";		
	}else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>No se pudo borrar el producto debido a que hay ventas asignadas a el.</font>";
	}
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
		return confirm("Estás seguro que queres agregar este producto?");
}
function confirmarM(){
		return confirm("Estás seguro que queres modificar este producto?");
}
function confirmarE(){
		return confirm("Estás seguro que queres eliminar este producto?");
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

<p align="center" class="titulo"><strong>Productos</strong></p>
<br>
<p class="error" align="center"><?=$msg?></p>
<?
if($ver != "listar"){
?>
	<table width="500" align="center" cellpadding="0" cellspacing="1">
		<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="formu">
			<?	if($id_producto == ""){?>
			  <input type="hidden" name="agregar" value="ok">
			  <tr height="30"><td class="t" colspan="4" align="center">Agregar una Producto</td></tr>
			<?	
				} 
				else{ 
					$q2 = query("SELECT * FROM productos WHERE id_producto = $id_producto");
					$rs2 = mysql_fetch_array($q2);
					$id_categoria = $rs2['id_categoria'];
					$id_linea = $rs2['id_linea'];
					$id_variedad = $rs2['id_variedad'];
					$id_presentacion = $rs2['id_presentacion'];
					$codigo = $rs2['codigo'];
					$detalle = $rs2['detalle'];
					$foto = $rs2['foto'];
					$dir = "../productos/".$foto;
					$ue = $rs2['ue'];
					$venta = $rs2['venta'];
			?>
			  <input type="hidden" name="id_producto" value="<?= $id_producto?>">
			  <input type="hidden" name="modificar" value="ok">
			  <tr height="30"><td class="t" colspan="4" align="center">Modificar el Producto</td></tr>
		 	<? }?>
			<tr height="30">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2" align="center">Categoria</td>
				<td width="500" class="c2">&nbsp;
					<select name="id_categoria">
						<option value="">Seleccionar la categoria</option>
						<option value="">----------------------------------</option>
						<? 
						$q_c = query("SELECT * FROM p_categorias ORDER BY categoria");
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
				<td width="150" class="c1" align="center">Linea</td>
				<td width="500" class="c1">&nbsp;
					<select name="id_linea">
						<option value="">Seleccionar la linea</option>
						<option value="">----------------------------------</option>
						<? 
						$q_l = query("SELECT * FROM p_lineas ORDER BY linea");
						while($rs_l = mysql_fetch_array($q_l)){ 
						?>
						<option value="<?= $rs_l['id_linea']?>" <? echo ($id_linea == $rs_l['id_linea'])?" SELECTED":""; ?> ><?= $rs_l['linea']?></option>
						<? }?>
					</select>
				</td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2" align="center">Variedad</td>
				<td width="500" class="c2">&nbsp;
					<select name="id_variedad">
						<option value="">Seleccionar la variedad</option>
						<option value="">----------------------------------</option>
						<? 
						$q_v = query("SELECT * FROM p_variedades ORDER BY variedad");
						while($rs_v = mysql_fetch_array($q_v)){ 
						?>
						<option value="<?= $rs_v['id_variedad']?>" <? echo ($id_variedad == $rs_v['id_variedad'])?" SELECTED":""; ?> ><?= $rs_v['variedad']?></option>
						<? }?>
					</select>
				</td>
				<td width="25" class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Presentacion</td>
				<td width="500" class="c1">&nbsp;
					<select name="id_presentacion">
						<option value="">Seleccionar la presentacion</option>
						<option value="">----------------------------------</option>
						<? 
						$q_p = query("SELECT * FROM p_presentacion ORDER BY presentacion");
						while($rs_p = mysql_fetch_array($q_p)){ 
						$v = "";
						if($rs_p['volumen'] != "") $v = " x ". $rs_p['volumen']." ml.";
						$presentacion = $rs_p['presentacion']." (".$rs_p['unidades']."". $v.")"
						?>
						<option value="<?= $rs_p['id_presentacion']?>" <? echo ($id_presentacion == $rs_p['id_presentacion'])?" SELECTED":""; ?> ><?= $presentacion?></option>
						<? }?>
					</select>
				</td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2" align="center">Codigo</td>
				<td width="500" class="c2">&nbsp;&nbsp;<input type="text" name="codigo" size="40" value="<?= $codigo?>"></td>
				<td width="25" class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">U Equivalente</td>
				<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="ue" value="<?= $ue?>" size="5"></td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Venta Online</td>
				<td width="500" class="c1">&nbsp;&nbsp;<input type="checkbox" name="venta" value="1" <?= $venta == 1 ? 'checked' : ''?>></td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="120">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2" align="center">Detalle</td>
				<td width="500" class="c2">&nbsp;&nbsp;<textarea name="detalle" rows="7" cols="50"><?= $detalle?></textarea></td>
				<td width="25" class="c2">&nbsp;</td>
			</tr>
			<tr height="60" valign="middle">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Foto</td>
				<td width="500" class="c1">
					<table cellpadding="0" cellspacing="0" border="0" width="90%">
						<tr valign="middle">
							<td>&nbsp;
							<?
									$tmp = listarArchivos("../productos/", "jpg");
									echo "<Select name='foto'>\n";
									echo "<option value=''>Elija la foto del producto</option>";
									echo "<option value=''>-----------------------------------</option>";
									for ($j=0; $j < count($tmp); $j++){
										if ($tmp[$j] != "Thumbs.db" && substr(strrchr($tmp[$j], '.'), 1) != "LCK"){
											$selected = $tmp[$j] == $foto ? "SELECTED":"";
											echo "<option value='". $tmp[$j] ."' $selected >". $tmp[$j] ."</option>\n";
										}
									}
									echo "</select>";
								?>&nbsp;&nbsp;<a href="javascript:popup('uploader.php?seccion=productos');"><img src="images/b_import.png" border="0" alt="Cargar una foto"></a>
							</td>
							<td>
								<? if($foto != ""){?>
									<a href="<?= $dir?>" title="Abrir la foto" target="_blank"><img src="<?= $dir?>" width="50" height="50" border="0"></a>
								<? }?>
							</td>
						</tr>
					</table>	
				</td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<?	if($id_producto == ""){?>
		  			<tr height="50">
						<td colspan="4" width="100%" class="t" align="center">
							<input type="image" name="enviar2" src="images/b_insert.png" alt="Agregar el Producto" onClick="return confirmarA();">&nbsp;&nbsp;
							<a href="<?= $_SERVER['PHP_SELF']?>?ver=listar"><img src="images/b_back.png" width="30" height="30" border="0" alt="Volver"></a>
						</td>
					</tr>
			<?	} else{ ?>
		  			<tr height="50">
						<td colspan="4" width="100%" class="t" align="center">
							<input type="image" name="enviar3" src="images/b_insert.png" alt="Modificar el Producto" onClick="return confirmarM();">&nbsp;&nbsp;
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
		<table width="800" align="center" cellpadding="0" cellspacing="1">
			<tr>
				<td>&nbsp;</td>
				<td align="center"><input name="GO" type="image" src="images/b_insert.png" alt="Guardar el nuevo orden" align="middle" width="25"></td>
				<td colspan="4">&nbsp;</td>
				<td align="center"><input name="GUE" type="image" src="images/b_insert.png" alt="Guardar las unidades equivalentes" align="middle" width="25"></td>
                <td align="center"><input name="GUE" type="image" src="images/b_insert.png" alt="Guardar las unidades equivalentes" align="middle" width="25"></td>
				<td align="center"><a href="<?= $_SERVER['PHP_SELF']?>?ver=insert"><img src="images/b_insert_new.png" border="0" alt="Insertar una nueva presentacion"></a></td>
				<td>&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="2%" class="t">&nbsp;</td>
				<td width="7%" class="t" align="center"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=p.orden" title="Ordenar x orden">Orden</a></td>
				<td width="13%" class="t">&nbsp;&nbsp;<a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=categoria" title="Ordenar x Categoria">Categoria</a></td>
				<td width="18%" class="t" align="center"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=linea" title="Ordenar x Linea">Linea</a></td>
				<td width="20%" class="t" align="center"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=variedad" title="Ordenar x Variedad">Variedad</a></td>
				<td width="20%" class="t" align="center"><a class="link_t" href="<?= $_SERVER['PHP_SELF']?>?ver=listar&order=presentacion" title="Ordenar x Presentacion">Presentacion</a></td>
				<td width="8%" class="t" align="center">UE</td>
                <td width="8%" class="t" align="center">Venta</td>
				<td width="10%" class="t">&nbsp;</td>
				<td width="2%" class="t">&nbsp;</td>
			</tr>
			<tr height="1"><td></td></tr>
			<?
			$order = $_REQUEST['order'];
			if($order == "") $order = "p.orden";
			$q = query("SELECT p.id_producto, p.ue, pc.id_categoria, pc.categoria, pl.linea, pv.variedad, pv.sigla, pp.presentacion, 
					   			pp.unidades, pp.volumen, p.orden, p.venta 
					    FROM productos p
						INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
						INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
						INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						ORDER BY $order");
			if(mysql_num_rows($q)>0){
				$t = 0;
				while($rs = mysql_fetch_array($q)){
					$c = $flag ? "c1":"c2";
					$flag =! $flag;	
					$id_producto = $rs['id_producto'];
					$categoria = $rs['categoria'];
					$linea = $rs['linea'];
					$variedad = $rs['variedad']." (".$rs['sigla'].")";
					$v = "";
					if($rs['volumen'] != "") $v = " x ". $rs['volumen']." ml.";
					$presentacion = $rs['presentacion']." (".$rs['unidades']."".$v.")";
					$orden = $rs['orden'];	
					$ue = $rs['ue'];
					$venta = $rs['venta'];
				?>
					<input type="hidden" name="id_producto_<?= $t?>" value="<?= $id_producto?>">
					<tr height="40" valign="middle">
						<td class="<?= $c?>">&nbsp;</td>
						<td class="<?= $c?>" align="center"><input name="orden_<?= $t?>" type="text" value="<?= $orden?>" size="1" style="text-align:center;"></td>
						<td class="<?= $c?>">&nbsp;&nbsp;<?= $categoria?></td>
						<td class="<?= $c?>" align="center"><?= $linea?></td>
						<td class="<?= $c?>" align="center"><?= $variedad?></td>
						<td class="<?= $c?>" align="center"><?= $presentacion?></td>
						<td class="<?= $c?>" align="center"><input name="ue_<?= $t?>" type="text" value="<?= $ue?>" size="3"></td>
                        <td class="<?= $c?>" align="center"><input type="checkbox" name="venta_<?= $t?>" value="1" <?= $venta == 1 ? 'checked' : ''?>></td>
						<td class="<?= $c?>" align="center">
							<a href="<?= $_SERVER['PHP_SELF']?>?id_producto=<?= $id_producto?>&ver=modificar"><img src="images/b_save.png" border="0" alt="Editar el producto"></a>&nbsp;&nbsp;
							<a href="<?= $_SERVER['PHP_SELF']?>?borrar=ok&id_producto=<?= $id_producto?>" onClick="return confirmarE();"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar este producto"></a>
						</td>
						<td class="<?= $c?>">&nbsp;</td>
					</tr>
				<? 
					$t++;	
				}
			}else{
				?>
				<tr height="60" valign="middle">
					<td class="c1" colspan="9" align="center">No hay ningun producto cargado</td>
				</tr>
				<?
			}
			?>
			<input type="hidden" name="Q" value="<?= $t?>">
			<tr height="15"><td colspan="9" class="t"></td></tr>
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
