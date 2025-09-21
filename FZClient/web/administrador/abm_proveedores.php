<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$ver = $_REQUEST['ver'];
if($ver == "") $ver = "listar";
$id_proveedor = $_REQUEST['id_proveedor']; 

// INSERTAR O IMPRIMIR
$insertar = "ok";
//$imprimir = "ok";
// ----------------

$id_tipo = $_REQUEST['id_tipo'];
$empresa = $_REQUEST['empresa'];
$cuit = $_REQUEST['cuit'];
$direccion = $_REQUEST['direccion'];
$atencion = $_REQUEST['atencion'];
$mail = $_REQUEST['mail'];
$telefono = $_REQUEST['telefono'];
$celular = $_REQUEST['celular'];
$observaciones = $_REQUEST['observaciones'];

if($_REQUEST['Agregar'] == "ok"){

	$sql = "INSERT INTO proveedores (id_proveedor, id_tipo, empresa, cuit, direccion, atencion, mail, telefono, celular, observaciones) VALUES (NULL, $id_tipo, '$empresa', '$cuit', '$direccion', '$atencion', '$mail', '$telefono', '$celular', '$observaciones')";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El proveedor '".$_REQUEST['empresa']."' se agrego correctamente</font>";
	$id_proveedor = ""; //oculta el form abm
}
if ($_REQUEST['Modificar']=="ok"){

	$sql= "UPDATE proveedores SET id_tipo= $id_tipo, empresa= '$empresa', cuit= '$cuit', direccion= '$direccion', atencion= '$atencion', mail= '$mail', telefono= '$telefono', celular= '$celular', observaciones= '$observaciones' WHERE id_proveedor=" . $id_proveedor;

		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El proveedor '".$_REQUEST['empresa']."' se modifico correctamente</font>";
	$id_proveedor = ""; //oculta el form abm
}
if ($_REQUEST['Borrar']== 'Borrar'){
	$q = query("SELECT * FROM insumos WHERE id_proveedor= ". $id_proveedor);
	if(mysql_num_rows($q)>0){
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>El Proveedor no se pudo borrar dado a que esta asociado a mas de un insumo.</font>";
	}else{
		$sql= "DELETE FROM proveedores WHERE id_proveedor= " . $id_proveedor;	
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$id_proveedor = ""; //oculta el form abm
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El proveedor '".$_REQUEST['empresa']."' se elimino correctamente</font>";
	}
	
}
if ($_REQUEST['Cancelar']=='Cancelar'){
	$id_proveedor = "";
}

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
<br>
<?
if($msg!="") echo("<div align='center'>".$msg."</div><br>");
?>
<br>
<?
if($ver != "listar"){
?>
	<table width="700" align="center" cellpadding="0" cellspacing="1">
		<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="formu">
			<? if($id_proveedor == ""){
				$empresa = $cuit = $direccion = $atencion = $telefono = $mail = $celular = $observaciones = "";
			?>
			<tr height="30"><td class="t" colspan="4" align="center">Agregar un Vendedor</td></tr>
			<? }?>
			<? 
			if($id_proveedor > 0){
				$q = query("SELECT * FROM proveedores WHERE id_proveedor= ". $id_proveedor);
				$rs = mysql_fetch_array($q);
				$id_tipo = $rs['id_tipo'];
					$q2 = query("SELECT * FROM tipo_proveedor WHERE id_tipo= ". $id_tipo);
					$rs2 = mysql_fetch_array($q2);
					$tipo_proveedor = $rs2['tipo'];
				$empresa = $rs['empresa'];
				$cuit = $rs['cuit'];
				$direccion = $rs['direccion'];
				$atencion = $rs['atencion'];
				$telefono = $rs['telefono'];
				$mail = $rs['mail'];
				$celular = $rs['celular'];
				$observaciones = $rs['observaciones'];
			?>
			<tr height="30"><td class="t" colspan="4" align="center">Modificar al Vendedor</td></tr>
			<? }?>
			<tr height="30">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2" align="center">Tipo de Proveedor</td>
				<td width="500" class="c2">&nbsp;&nbsp;
					<select name="id_tipo">
						<option value="0">Seleccione el tipo de proveedor</option>
						<? $q_t = query("SELECT * FROM tipo_proveedor order by tipo");
							while($rs_t=mysql_fetch_array($q_t)){ ?>
						<option value="<?=$rs_t['id_tipo']?>" <? echo ($rs_t['id_tipo'] == $id_tipo)?"SELECTED":""?>><?= $rs_t['tipo']?></option>
						<? }?>
					</select>
				</td>
				<td width="25" class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Empresa</td>
				<td width="500" class="c1">&nbsp;&nbsp;<input name="empresa" type="text" id="empresa" value="<?=$empresa?>" size="40"></td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2" align="center">Cuit</td>
				<td class="c2">&nbsp;&nbsp;<input type="text" name="cuit"  value="<?=$cuit?>" size="40"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1" align="center">Direccion</td>
				<td class="c1">&nbsp;&nbsp;<input type="text" name="direccion"  value="<?=$direccion?>" size="40"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2" align="center">Atencion</td>
				<td class="c2">&nbsp;&nbsp;<input type="text" name="atencion"  value="<?=$atencion?>" size="40"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1" align="center">Mail</td>
				<td class="c1">&nbsp;&nbsp;<input type="text" name="mail"  value="<?=$mail?>" size="40"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2" align="center">Telefono</td>
				<td class="c2">&nbsp;&nbsp;<input name="telefono" type="text" id="telefono"  value="<?=$telefono?>" size="15"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1" align="center">Celular</td>
				<td class="c1">&nbsp;&nbsp;<input type="text" name="celular" value="<?=$celular?>" size="15"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2" align="center">Observaciones</td>
				<td class="c2">&nbsp;&nbsp;<textarea name="observaciones" cols="80" rows="6"><?=$observaciones?></textarea></td>
				<td class="c2">&nbsp;</td>
			</tr>
				<?
				if ($id_proveedor > 0){
				?>
					<tr height="50">
						<td width="25" class="t">&nbsp;</td>
						<td colspan="2" class="t" align="center">
							<input type="hidden" value="<?=$rs['id_proveedor']?>" name="id_proveedor">
							<input type="image" src="images/b_save.png" onClick="return confirmarM();">
							<input type="hidden" name="Modificar" value="ok">&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?= $_SERVER['PHP_SELF']?>?Cancelar=Cancelar"><img src="images/b_back.png" width="30" height="30" border="0" alt="Cancelar"></a>&nbsp;&nbsp;&nbsp;&nbsp;		
						</td>
						<td width="25" class="t">&nbsp;</td>
					</tr>
				<? }else{?> 
					<tr height="50">
						<td width="25" class="t">&nbsp;</td>
						<td colspan="2" class="t" align="center">
							<input type="image" src="images/b_insert.png" onClick="return confirmarA();">
							<input type="hidden" name="Agregar" value="ok">&nbsp;&nbsp;
							<a href="<?= $_SERVER['PHP_SELF']?>?Cancelar=Cancelar"><img src="images/b_back.png" width="30" height="30" border="0" alt="Cancelar"></a>
						</td>
						<td width="25" class="t">&nbsp;</td>
					</tr>
				<? }?>
		</form>
	</table>
<?
}
else{ // si no es LISTAR
?>
	<table width="900" align="center" cellpadding="0" cellspacing="1" border="0">
		<tr>
			<td width="25">&nbsp;</td>
			<td width="350" class="encabezado">&nbsp;Listado de proveedores</td>
			<td width="400" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?ver=insert"><img src="images/b_insert_new.png" border="0" alt="Ingresar un nuevo Vendedor"></a></td>
			<td width="25">&nbsp;</td>
		</tr>
		<tr height="40">
			<td colspan="4">
				<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
					<tr height="35">
						<td width="2%" class="t"></td>
						<td width="25%" class="t">Empresa</td>
						<td width="35%" class="t">Atencion</td>
						<td width="25%" class="t">Telefono</td>
						<td width="13%" class="t" colspan="2">&nbsp;</td>
					</tr>
					<?
					$q = query("SELECT * from proveedores ORDER BY empresa");
					while($rs = mysql_fetch_array($q)){
						$id_proveedor = $rs['id_proveedor'];
						$empresa = $rs['empresa'];
						$atencion = $rs['atencion'];
						$telefono = $rs['telefono'];
						$mail = $rs['mail'];
						$celular = $rs['celular'];
						
						$c = $flag ? "c1":"c2";
						$flag =! $flag;		
						?>
						<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
						  <tr height="40">
							<td class="<?= $c?>"></td>
							<td class="<?= $c?>"><?= substr($empresa, 0, 25)?></td>
							<td class="<?= $c?>"><?= substr($atencion, 0, 25)?><br><?= substr($mail,0,30)?></td>
							<td class="<?= $c?>"><?= $telefono?><br><?= $celular?></td>
							<td class="<?= $c?>" colspan="2" align="center">
								<a href="<?=$_SERVER['PHP_SELF']?>?id_proveedor=<?= $id_proveedor?>&ver=modificar"><img src="images/b_save.png" border="0" alt="Detalle del proveedor <?= $empresa?>"></a>&nbsp;&nbsp;
								<a href="<?= $_SERVER['PHP_SELF']?>?Borrar=Borrar&id_proveedor=<?= $id_proveedor?>&empresa=<?= $rs['empresa']?>" onClick="return confirmarE();"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar el vendedor <?= $rs['nombre']?>"></a>
								<input type="hidden" name="ver" value="Detalle">
								<input type="hidden" name="id_proveedor" value="<?=$id_proveedor?>">
							</td>
						  </tr>
						  </form>
					<? }?>
					<tr height="15"><td colspan="6" class="t">&nbsp;</td></tr>
				</table>
			</td>
		</tr>
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
