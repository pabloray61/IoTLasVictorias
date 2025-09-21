<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$ver = $_REQUEST['ver'];
if($ver == "") $ver = "listar";
$id_vendedor = $_REQUEST['id_vendedor']; //uso vendedor2 para que no haga kilombo con la session['id_vendedor']

// INSERTAR O IMPRIMIR
$insertar = "ok";
//$imprimir = "ok";
// ----------------


if($_REQUEST['Agregar']=="Agregar"){

	$sql="INSERT INTO vendedores (id_vendedor, nombre, sigla, telefono, mail, direccion,celular, observaciones, pass)
	 VALUES (NULL,'". $_REQUEST['nombre'] . "','". $_REQUEST['sigla'] . "', '" . $_REQUEST['telefono']. "','". $_REQUEST['mail']."', 
	 '".$_REQUEST['direccion']."', '".$_REQUEST['celular']."','". $_REQUEST['observaciones'] ."', '".$_REQUEST['pass']."')";

		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El vendedor '".$_REQUEST['nombre']."' se agrego correctamente</font>";
	$id_vendedor = ""; //oculta el form abm
}
if ($_REQUEST['Modificar']=="Modificar"){

	$sql= "UPDATE vendedores SET nombre = '". $_REQUEST['nombre'] ."',
	sigla='".$_REQUEST['sigla']."',
	telefono='".$_REQUEST['telefono']."',
	mail='".$_REQUEST['mail']."',
	direccion='".$_REQUEST['direccion']."',
	celular='".$_REQUEST['celular']."',
	observaciones='".$_REQUEST['observaciones']."',
	pass = '".$_REQUEST['pass']."'
	  WHERE id_vendedor= " . $id_vendedor;

		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El vendedor '".$_REQUEST['nombre']."' se modifico correctamente</font>";
	$id_vendedor = ""; //oculta el form abm
}
if ($_REQUEST['Borrar']== 'Borrar'){
	$q = query("SELECT * FROM ventas WHERE id_vendedor= ". $id_vendedor);
	if(mysql_num_rows($q)>0){
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>El vendedor no se pudo borrar dado a que esta asociado a mas de una venta.</font>";
	}else{
		$sql= "DELETE FROM vendedores WHERE id_vendedor= " . $id_vendedor;	
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$id_vendedor = ""; //oculta el form abm
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El vendedor '".$_REQUEST['nombre']."' se elimino correctamente</font>";
	}
	
}
if ($_REQUEST['Cancelar']=='Cancelar'){
	$id_vendedor = "";
}
if ($_REQUEST['acc'] == 'activar'){
	$sql= "UPDATE vendedores SET activo = 1 WHERE id_vendedor= " . $id_vendedor;
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El vendedor '".$_REQUEST['nombre']."' se activo correctamente</font>";
}
if ($_REQUEST['acc'] == 'desactivar'){
	$sql= "UPDATE vendedores SET activo = 0 WHERE id_vendedor= " . $id_vendedor;
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El vendedor '".$_REQUEST['nombre']."' se desactivo correctamente</font>";
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
			<? if($id_vendedor == ""){
				$nombre="";
				$sigla= "";
				$telefono="";
				$mail="";
				$direccion="";
				$celular="";
				$observaciones="";
			?>
			<tr height="30"><td class="t" colspan="4" align="center">Agregar un Vendedor</td></tr>
			<? }?>
			<? 
			if($id_vendedor > 0){
				$q = query("SELECT * FROM vendedores WHERE id_vendedor= ". $id_vendedor);
				$rs = mysql_fetch_array($q);
				$nombre = $rs['nombre'];
				$sigla = $rs['sigla'];
				$telefono = $rs['telefono'];
				$mail = $rs['mail'];
				$direccion = $rs['direccion'];
				$celular = $rs['celular'];
				$observaciones = $rs['observaciones'];
				$pass = $rs['pass'];
			?>
			<tr height="30"><td class="t" colspan="4" align="center">Modificar al Vendedor</td></tr>
			<? }?>
			<tr height="30">
				<td width="25" class="c1">&nbsp;</td>
				<td width="150" class="c1" align="center">Nombre</td>
				<td width="500" class="c1">&nbsp;&nbsp;<input name="nombre" type="text" id="nombre" value="<?=$nombre?>" size="40"></td>
				<td width="25" class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2" align="center">Sigla</td>
				<td class="c2">&nbsp;&nbsp;<input type="text" name="sigla"  value="<?=$sigla?>" size="40"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1" align="center">Contraseña</td>
				<td class="c1">&nbsp;&nbsp;<input type="text" name="pass"  value="<?=$pass?>" size="10"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2" align="center">Telefono</td>
				<td class="c2">&nbsp;&nbsp;<input name="telefono" type="text" id="telefono"  value="<?=$telefono?>" size="20"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1" align="center">Celular</td>
				<td class="c1">&nbsp;&nbsp;<input type="text" name="celular" value="<?=$celular?>" size="20"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2" align="center">Mail</td>
				<td class="c2">&nbsp;&nbsp;<input type="text" name="mail"  value="<?=$mail?>" size="40"></td>
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
				<td class="c2" align="center">Observaciones</td>
				<td class="c2">&nbsp;&nbsp;<textarea name="observaciones" cols="80" rows="6"><?=$observaciones?></textarea></td>
				<td class="c2">&nbsp;</td>
			</tr>
				<?
				if ($id_vendedor > 0){
				?>
					<tr height="50">
						<td width="25" class="t">&nbsp;</td>
						<td colspan="2" class="t" align="center">
							<input type="hidden" value="<?=$rs['id_vendedor']?>" name="id_vendedor">
							<input type="image" src="images/b_save.png" onClick="return confirmarM();">
							<input type="hidden" name="Modificar" value="Modificar">&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?= $_SERVER['PHP_SELF']?>?Cancelar=Cancelar"><img src="images/b_back.png" width="30" height="30" border="0" alt="Cancelar"></a>&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?=$_SERVER['PHP_SELF']?>?id_cliente=<?= $id_cliente?>&historial=historial"><img src="images/historial.png" border="0" alt="Historial del cliente <?= $apellido?>" width="30" height="30"></a>							
						</td>
						<td width="25" class="t">&nbsp;</td>
					</tr>
				<? }else{?> 
					<tr height="50">
						<td width="25" class="t">&nbsp;</td>
						<td colspan="2" class="t" align="center">
							<input type="image" src="images/b_insert.png" onClick="return confirmarA();">
							<input type="hidden" name="Agregar" value="Agregar">&nbsp;&nbsp;
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
			<td width="400" class="encabezado">&nbsp;Listado de Vendedores</td>
			<td width="450" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?ver=insert"><img src="images/b_insert_new.png" border="0" alt="Ingresar un nuevo Vendedor"></a></td>
			<td width="25">&nbsp;</td>
		</tr>
		<tr height="40">
			<td colspan="4">
				<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
					<tr height="35">
						<td width="3%" class="t"></td>
						<td width="18%" class="t">Nombre</td>
						<td width="9%" class="t" align="center">Sigla</td>
						<td width="25%" class="t">E-mail</td>
						<td width="13%" class="t">Telefono</td>
						<td width="15%" class="t">Celular</td>
						<td width="17%" class="t" colspan="2">&nbsp;</td>
					</tr>
					<?
					$q = query("SELECT * from vendedores ORDER BY nombre");
					while($rs = mysql_fetch_array($q)){
						$id_vendedor = $rs['id_vendedor'];
						$sigla = $rs['sigla'];
						$nombre = $rs['nombre'];
						$telefono = $rs['telefono'];
						$mail = $rs['mail'];
						$celular = $rs['celular'];
						$activo = $rs['activo'];
						
						$c = $flag ? "c1":"c2";
						$flag =! $flag;		
						?>
						<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
						  <tr height="40">
							<td class="<?= $c?>"></td>
							<td class="<?= $c?>"><?= $nombre?></td>
							<td class="<?= $c?>" align="center"><?= $sigla?></td>
							<td class="<?= $c?>"><?= substr($mail,0,30)?></td>
							<td class="<?= $c?>"><?= $telefono?></td>
							<td class="<?= $c?>"><?= $celular?></td>
							<td class="<?= $c?>" colspan="2" align="center">
								<? if($id_vendedor != 1){?>
									<? if($activo == 0){?>
										<a href="<?=$_SERVER['PHP_SELF']?>?id_vendedor=<?= $id_vendedor?>&nombre=<?= $rs['nombre']?>&acc=activar"><img src="images/desactivo.png" border="0" alt="Activar al vendedor <?= $apellido?>" width="30" height="30"></a>&nbsp;&nbsp;
									<? }?>
									<? if($activo == 1){?>
										<a href="<?=$_SERVER['PHP_SELF']?>?id_vendedor=<?= $id_vendedor?>&nombre=<?= $rs['nombre']?>&acc=desactivar"><img src="images/activo.png" border="0" alt="Desactivar al vendedor <?= $apellido?>" width="30" height="30"></a>&nbsp;&nbsp;
									<? }?>
								<? }?>
								<a href="<?=$_SERVER['PHP_SELF']?>?id_vendedor=<?= $id_vendedor?>&ver=modificar"><img src="images/b_save.png" border="0" alt="Detalle del vendedor <?= $apellido?>"></a>&nbsp;&nbsp;
								<? if($id_vendedor != 1){?>
									<a href="<?= $_SERVER['PHP_SELF']?>?Borrar=Borrar&id_vendedor=<?= $rs['id_vendedor']?>&nombre=<?= $rs['nombre']?>" onClick="return confirmarE();"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar el vendedor <?= $rs['nombre']?>"></a>
								<? }?>
								<input type="hidden" name="ver" value="Detalle">
								<input type="hidden" name="id_vendedor" value="<?=$id_vendedor?>">
							</td>
						  </tr>
						  </form>
					<? }?>
					<tr height="15"><td colspan="8" class="t">&nbsp;</td></tr>
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
