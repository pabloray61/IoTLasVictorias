<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

if($_REQUEST['actualizar']=="Actualizar"){

	$sql="SELECT pass FROM vendedores WHERE id_vendedor=" . $_SESSION['id_vendedor'];
	//echo $sql;
	$q = query($sql);
	
	$rs=mysql_fetch_array($q);

	//que ingrese bien el pass viejo
	if($_REQUEST['old_pass']==$rs['pass']){
	
		//que el pass ingresado este bien confirmado
		if($_REQUEST['new_pass']==$_REQUEST['confirm_pass'] and $_REQUEST['new_pass']!=""){
				$sql="UPDATE vendedores SET pass='".$_REQUEST['new_pass']."' WHERE id_vendedor = ".$_SESSION['id_vendedor'];
				//echo $sql;
				mysql_query($sql, $conn_id);
				$msg="<p align='center' class='bien'>La clave se actualizo con éxito</p>";
		}else{
			$msg= "<p align='center' class='error'>Error al cambiar la clave, por favor verifique los datos ingresados</p>";
		}
	
	}else{
		$msg="<p align='center' class='error'>Verifique el password ingresado</p>";
	}
}

if($_REQUEST['Reset']=="Reset"){
	query("UPDATE vendedores SET pass='111' where id_vendedor=" . $_REQUEST['id_v']);
	echo $_REQUEST['id_v'];

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
<p align="center" class="titulo">Cambio de clave</p>
<br>
<?=$msg?>
<form name="change_pass" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table align="center">
<?
$sql="SELECT nombre, pass FROM vendedores WHERE id_vendedor=". $_SESSION['id_vendedor'];
$q= query($sql);

$rs=mysql_fetch_array($q)
?>	


<tr>
  <td class="encabezado">Vendedor</td>
  <td class="data"><?=$rs['nombre'];?></td></tr>
<tr><td class="encabezado">Contraseña actual</td>
<td><input type="password" name="old_pass"></td></tr>
<tr><td class="encabezado">Contraseña nueva</td>
<td><input type="password" name="new_pass"></td></tr>
<tr><td class="encabezado">Confirmar contaseña</td>
<td><input type="password" name="confirm_pass"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="actualizar" value="Actualizar"></td></tr>
</table>
</form>
	<br>
<?
if($_SESSION['admin']=='ok'){
?>
	<table align="center">
	<tr>
	  <td colspan="2" class="encabezado">Establecer clave en '111' </td>
	  </tr>
	<tr>
		<td class="encabezado">Vendedor</td>
		<td></td>
	</tr>
<?
$sql="SELECT id_vendedor, nombre from vendedores where id_vendedor>1";
$q=query($sql);
while($rs=mysql_fetch_array($q)){
?>
	<form action="">
	<tr>
		<td class="data"><?=$rs['nombre']?></td>
		<td><input type="submit" value="Reset" name="Reset"><input type="hidden" name="id_v" value="<?=$rs['id_vendedor']?>"></td>
	</tr>
	</form>
<?
}?>

	</table>
	<?}?>
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
