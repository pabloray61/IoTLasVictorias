<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$ver = $_REQUEST['ver'];
if($ver == "") $ver = "listar";

$id_linea = $_REQUEST["id_linea"];
$linea = $_REQUEST["linea"];
$detalle = $_REQUEST["detalle"];
$foto = $_REQUEST["foto"];

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["agregar"] == "agregar" and $_REQUEST["linea"] != ""){
	$q2 = query("SELECT * FROM p_lineas WHERE linea = '$linea'");
	$cant = mysql_num_rows($q2);
	if ($cant == 0){		
		$sql =  "INSERT INTO p_lineas VALUES (null,'$linea', '$detalle', '$foto')";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La linea '".$linea."' se agrego correctamente</font>";
	}
	else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>La linea '".$linea."' ya se encuentra cargada</font>";
	}
}
if ($_REQUEST['modificar'] == "modificar"){
	$sql = "UPDATE p_lineas SET linea= '$linea', detalle= '$detalle', foto= '$foto' WHERE id_linea = '" . $_REQUEST['id_linea'] ."'";
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La linea '".$linea."' se modifico correctamente</font>";
}

if ($_REQUEST["borrar"]=='Borrar'){

	$id_linea = $_REQUEST['id_linea'];
	$q = query("SELECT count(*) as cant FROM productos WHERE id_linea = $id_linea");
	$rs = mysql_fetch_array($q);
	if ($rs['cant'] == 0){
		$sql = "DELETE FROM p_lineas where id_linea = '" . $_REQUEST['id_linea'] . "'";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La linea '".$linea."' se elimino correctamente</font>";		
	}else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>No se pudo borrar la linea '".$linea."' debido a que hay productos asignados a ella.</font>";
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
		return confirm("Estás seguro que queres agregar esta linea?");
}
function confirmarM(){
		return confirm("Estás seguro que queres modificar esta linea?");
}
function confirmarE(){
		return confirm("Estás seguro que queres eliminar esta linea?");
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

<p align="center" class="titulo"><strong>Lineas de productos</strong></p>
<br>
<p class="error" align="center"><?=$msg?></p>
<?
if($ver != "listar"){
?>
	<table width="500" align="center" cellpadding="0" cellspacing="1">
		<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="formu">
			<?	if($id_linea == ""){?>
			  <input type="hidden" name="agregar" value="agregar">
			  <tr height="30"><td class="t" colspan="4" align="center">Agregar una Linea</td></tr>
			<?	
				} 
				else{ 
					$q2 = query("SELECT * FROM p_lineas WHERE id_linea = $id_linea");
					$rs2 = mysql_fetch_array($q2);
					$linea = $rs2['linea'];
					$detalle = $rs2['detalle'];
					$foto = $rs2['foto'];
					$dir = "../lineas/".$foto;
			?>
			  <input type="hidden" name="id_linea" value="<?= $id_linea?>">
			  <input type="hidden" name="modificar" value="modificar">
			  <tr height="30"><td class="t" colspan="4" align="center">Modificar la linea</td></tr>
		 	<? }?>
			<tr height="30">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2"><div align="center">Linea</div></td>
				<td width="500" class="c2">&nbsp;&nbsp;<input type="text" name="linea" value="<?= $linea?>" size="50"></td>
				<td width="25" class="c2">&nbsp;</td>
			</tr>
			<tr height="120">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1"><div align="center">Detalle</div></td>
				<td width="500" class="c1">&nbsp;&nbsp;<textarea name="detalle" rows="7" cols="50"><?= $detalle?></textarea></td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="60" valign="middle">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2"><div align="center">Foto</div></td>
				<td width="500" class="c2">
					<table cellpadding="0" cellspacing="0" border="0" width="90%">
						<tr valign="middle">
							<td>&nbsp;
							<?
									$tmp = listarArchivos("../lineas/", "jpg");
									echo "<Select name='foto'>\n";
									echo "<option value=''>Elija la foto de la linea</option>";
									echo "<option value=''>-----------------------------------</option>";
									for ($j=0; $j < count($tmp); $j++){
										if ($tmp[$j] != "Thumbs.db" && substr(strrchr($tmp[$j], '.'), 1) != "LCK"){
											$selected = $tmp[$j] == $foto ? "SELECTED":"";
											echo "<option value='". $tmp[$j] ."' $selected >". $tmp[$j] ."</option>\n";
										}
									}
									echo "</select>";
								?>&nbsp;&nbsp;<a href="javascript:popup('uploader.php?seccion=lineas');"><img src="images/b_import.png" border="0" alt="Cargar una foto"></a>
							</td>
							<td>
								<? if($foto != ""){?>
									<a href="<?= $dir?>" title="Abrir la foto" target="_blank"><img src="<?= $dir?>" width="50" height="50" border="0"></a>
								<? }?>
							</td>
						</tr>
					</table>	
				</td>
				<td width="25" class="c2">&nbsp;</td>
			</tr>
			<?	if($id_linea == ""){?>
		  			<tr height="50">
						<td colspan="4" width="100%" class="t" align="center">
							<input type="image" name="enviar2" src="images/b_insert.png" alt="Agregar la linea" onClick="return confirmarA();">&nbsp;&nbsp;
							<a href="<?= $_SERVER['PHP_SELF']?>?ver=listar"><img src="images/b_back.png" width="30" height="30" border="0" alt="Volver"></a>
						</td>
					</tr>
			<?	} else{ ?>
		  			<tr height="50">
						<td colspan="4" width="100%" class="t" align="center">
							<input type="image" name="enviar3" src="images/b_insert.png" alt="Modificar el producto" onClick="return confirmarM();">&nbsp;&nbsp;
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
	<table width="400" align="center" cellpadding="0" cellspacing="1">
		<tr><td colspan="4" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?ver=insert"><img src="images/b_insert_new.png" border="0" alt="Insertar una nueva linea"></a></td></tr>
		<tr height="30">
			<td width="25" class="t">&nbsp;</td>
			<td width="250" class="t">&nbsp;&nbsp;Lineas Cargadas</td>
			<td width="100" class="t">&nbsp;</td>
			<td width="25" class="t">&nbsp;</td>
		</tr>
		<tr height="1"><td></td></tr>
		<?
		$q = query("SELECT * FROM p_lineas ORDER BY linea");
		if(mysql_num_rows($q)>0){
			while($rs = mysql_fetch_array($q)){
				$c = $flag ? "c1":"c2";
				$flag =! $flag;	
				$id_linea = $rs['id_linea'];
				if($rs['foto'] != "") $dir = "../lineas/".$rs['foto'];
				if($rs['foto'] == "") $dir = "";
			?>
				<tr height="60" valign="middle">
					<td class="<?= $c?>">&nbsp;</td>
					<td class="<?= $c?>">
						<table cellpadding="0" cellspacing="0" border="0" width="90%" align="center">
							<tr>
								<td class="<?= $c?>"><? if($dir != ""){?><a href="<?= $dir?>" title="Abrir la foto" target="_blank"><img src="<?= $dir?>" width="50" height="50" border="0"></a><? }?></td>
								<td class="<?= $c?>">&nbsp;&nbsp;<?= $rs['linea']?></td>
							</tr>
						</table>
					</td>
					<td class="<?= $c?>">&nbsp;&nbsp;
						<a href="<?= $_SERVER['PHP_SELF']?>?id_linea=<?= $id_linea?>&ver=modificar"><img src="images/b_save.png" border="0" alt="Editar la linea <?= $rs['linea']?>"></a>
						<a href="<?= $_SERVER['PHP_SELF']?>?borrar=Borrar&id_linea=<?= $rs['id_linea']?>&linea=<?= $rs['linea']?>" onClick="return confirmarE();"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar la linea <?= $rs['linea']?>"></a>
					</td>
					<td class="<?= $c?>">&nbsp;</td>
				</tr>
				</form>
			<? 	
			}
		}
		?>
		<tr height="15"><td colspan="5" class="t"></td></tr>
	</table>
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
