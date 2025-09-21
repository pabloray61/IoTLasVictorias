<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$ver = $_REQUEST['ver'];
if($ver == "") $ver = "listar";
$id_cliente = $_REQUEST['id_cliente'];
$id_cliente2 = $_REQUEST['id_cliente2'];


// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------
$id = $_REQUEST['id_cliente'];
$id2 = $_REQUEST['id_cliente2'];
if($_REQUEST['acc'] == "transferir" AND $id != "" AND $id2 != ""){
	$sql_ve = "UPDATE ventas SET id_cliente = $id2 WHERE id_cliente = $id";
	if($insertar == "ok") query($sql_ve);
	if($imprimir == "ok") echo $sql_ve . "<br>";
	$sql_vi = "UPDATE visitas SET id_cliente = $id2 WHERE id_cliente = $id";
	if($insertar == "ok") query($sql_vi);
	if($imprimir == "ok") echo $sql_vi . "<br>";
	$sql_ll = "UPDATE llamados SET id_cliente = $id2 WHERE id_cliente = $id";
	if($insertar == "ok") query($sql_ll);
	if($imprimir == "ok") echo $sql_ll . "<br>";
	header ("location: abm_clientes.php?mst=Las%20datos%20se%20transfirieron%20correctamente");
}else{
	if($_REQUEST['acc'] == "transferir"){
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>Debe seleccinar el cliente al que le desea transferir las ventas</font>";
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
<SCRIPT LANGUAGE="JavaScript" src="calendar1.js">
function confirmarA(){
		return confirm("Estás seguro que queres agregar este Cliente?");
}
function confirmarM(){
		return confirm("Estás seguro que queres modificar este Cliente?");
}
function confirmarE(){
		return confirm("Estás seguro que queres eliminar este Cliente?");
}
</SCRIPT>

<link rel="stylesheet" type="text/css" href="js/autocompletar.css">
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/ajax-dynamic-list.js"></script>

<?
	require("funciones_java.php");
?>
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
if($msg != "") echo("<div align='center'>".$msg."</div><br>");
?>
<br>
<?
// ID CLIENTE I

$q = query("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
$rs = mysql_fetch_array($q);
$apellido = $rs['apellido'];
$nombre = $rs['nombre'];
if($nombre != "") $apellido = $apellido.", ".$nombre; 
if($rs['poe'] != 2 && $rs['dni'] != "") $dni = "DNI: ".$rs['dni'];
if($rs['poe'] == 2 && $rs['cuit'] != "") $dni = "CUIT: ".$r2['cuit'];

$qve = query("SELECT count(*) AS n FROM ventas WHERE id_cliente = $id_cliente");
$ve = mysql_fetch_array($qve);
$qvi = query("SELECT count(*) AS n FROM visitas WHERE id_cliente = $id_cliente");
$vi = mysql_fetch_array($qvi);
$qll = query("SELECT count(*) AS n FROM llamados WHERE id_cliente = $id_cliente");
$ll = mysql_fetch_array($qll);
if($ve['n'] != "" AND $ve['n'] > 0) $txt = $ve['n']." ventas | ";
if($vi['n'] != "" AND $vi['n'] > 0) $txt .= $vi['n']." visitas | ";
if($ll['n'] != "" AND $ll['n'] > 0) $txt .= $ll['n']." llamados | ";
$txt = substr($txt, 0, (strlen($txt) - 3));

// ID CLIENTE II
if($id_cliente2 != ""){
	$q2 = query("SELECT * FROM clientes WHERE id_cliente = $id_cliente2");
	$rs2 = mysql_fetch_array($q2);
	$apellido2 = $rs2['apellido'];
	$nombre2 = $rs2['nombre'];
	if($nombre2 != "") $apellido2 = $apellido2.", ".$nombre2; 
	if($rs2['poe'] != 2 && $rs2['dni'] != "") $dni2 = "DNI: ".$rs2['dni'];
	if($rs2['poe'] == 2 && $rs2['cuit'] != "") $dni2 = "CUIT: ".$rs2['cuit'];
	$qve2 = query("SELECT count(*) AS n FROM ventas WHERE id_cliente = $id_cliente2");
	$ve2 = mysql_fetch_array($qve2);
	$qvi2 = query("SELECT count(*) AS n FROM visitas WHERE id_cliente = $id_cliente2");
	$vi2 = mysql_fetch_array($qvi2);
	$qll2 = query("SELECT count(*) AS n FROM llamados WHERE id_cliente = $id_cliente2");
	$ll2 = mysql_fetch_array($qll2);
	if($ve2['n'] != "" AND $ve2['n'] > 0) $txt2 = $ve2['n']." ventas | ";
	if($vi2['n'] != "" AND $vi2['n'] > 0) $txt2 .= $vi2['n']." visitas | ";
	if($ll2['n'] != "" AND $ll2['n'] > 0) $txt2 .= $ll2['n']." llamados | ";
	$txt2 = substr($txt2, 0, (strlen($txt2) - 3));
}
?>
<form method="post" name="formu" action="<?=$_SERVER['PHP_SELF']?>">
	<input type="hidden" name="id_cliente" value="<?= $id_cliente?>">
	<table width="800" cellpadding="0" cellspacing="0" border="0" align="center">
		<tr valign="top">
			<td width="45%">
				<table width="300" align="center" cellpadding="0" cellspacing="0">
					<tr height="30">
						<td width="25" class="t">&nbsp;</td>
						<td width="250" class="t"><div align="center">Transferir datos de</div></td>
						<td width="25" class="t">&nbsp;</td>
					</tr>
					<tr height="30">
						<td class="c1">&nbsp;</td>
						<td class="c1" align="center"><?= $apellido?></td>
						<td class="c1">&nbsp;</td>
					</tr>
					<tr height="30">
						<td class="c2">&nbsp;</td>
						<td class="c2" align="center"><?= $dni?></td>
						<td class="c2">&nbsp;</td>
					</tr>
					<tr height="30">
						<td class="c1">&nbsp;</td>
						<td class="c1" align="center"><?= $txt?></td>
						<td class="c1">&nbsp;</td>
					</tr>
					<tr height="10"><td class="t" colspan="3"></td></tr>
				</table>		
			</td>
			<td width="10%" align="center"><br><br><a href="<?= $_SERVER['PHP_SELF']?>?acc=transferir&id_cliente=<?= $id_cliente?>&id_cliente2=<?= $id_cliente2?>" onMouseOver="ser.src='images/b_paso_on.png';" onMouseOut="ser.src='images/b_paso_off.png';" title="Transferir las ventas"><img name="ser" src="images/b_paso_off.png" border="0"></a></td>
			<td width="45%">
				<table width="300" align="center" cellpadding="0" cellspacing="0">
					<tr height="30">
						<td width="25" class="t">&nbsp;</td>
						<td width="250" class="t"><div align="center">Recibe datos</div></td>
						<td width="25" class="t">&nbsp;</td>
					</tr>
					<tr height="30">
						<td class="c1">&nbsp;</td>
						<td class="c1" align="center">
						  <select name="id_cliente2" onChange="formu.submit();">
							  <option>Seleccione un cliente</option>
								<?
								if($_SESSION['admin']=="ok") $q3 = query("SELECT * FROM clientes ORDER BY apellido, nombre");
								if($_SESSION['admin']!="ok") $q3 = query("SELECT * FROM clientes WHERE id_vendedor = ".$_SESSION['id_vendedor'] ." ORDER BY apellido, nombre");				  
								while($rs3 = mysql_fetch_array($q3)){
									if($rs3['id_cliente'] != $id_cliente){?>
										<option value="<?= $rs3['id_cliente']?>" <?  if($id_cliente2 == $rs3['id_cliente']){ echo "SELECTED";} ?>><?= substr($rs3['apellido'].", ".$rs3['nombre'], 0, 30)?></option>
									<? }?>
								<? }?>
						  </select>
						</td>
						<td class="c1">&nbsp;</td>
					</tr>
					<tr height="30">
						<td class="c2">&nbsp;</td>
						<td class="c2" align="center"><?= $dni2?></td>
						<td class="c2">&nbsp;</td>
					</tr>
					<tr height="30">
						<td class="c1">&nbsp;</td>
						<td class="c1" align="center"><?= $txt2?></td>
						<td class="c1">&nbsp;</td>
					</tr>
					<tr height="10"><td class="t" colspan="3"></td></tr>
				</table>	
			</td>
		</tr>
	</table>
</form>

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
