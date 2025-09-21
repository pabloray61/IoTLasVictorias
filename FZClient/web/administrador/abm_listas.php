<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$lista = $_REQUEST["lista"];
$sigla = $_REQUEST['sigla'];

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["Agregar"] == "ok" and $_REQUEST["lista"] != ""){
	$q2 = query("SELECT * FROM listas WHERE lista = '$lista'");
	if (mysql_num_rows($q2) == 0){
		$q3 = query("SELECT * FROM listas WHERE sigla = '$sigla'");
		if (mysql_num_rows($q3) == 0){
			$sql =  "INSERT INTO listas VALUES (null,'$lista', '$sigla')";
			if($insertar == "ok") mysql_query($sql, $conn_id);
			if($imprimir == "ok") echo("SQL: ".$sql);
			$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La lista '".$lista."' se agrego correctamente</font>";
		}
		else{
			$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>La Sigla '".$sigla."' ya se encuentra utilizada</font>";
		}
	}
	else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>La lista '".$lista."' ya se encuentra cargada</font>";
	}
}
if ($_REQUEST['modificar'] == "ok"){
	$id_lista = $_REQUEST['id_lista'];
	$q3 = query("SELECT * FROM listas WHERE sigla = '$sigla' AND id_lista != $id_lista");
	if (mysql_num_rows($q3) == 0){
		$sql = "UPDATE listas SET lista= '$lista', sigla= '$sigla' WHERE id_lista = $id_lista";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La lista '".$lista."' se modifico correctamente</font>";
	}
	else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>La Sigla '".$sigla."' ya se encuentra utilizada</font>";
	}
}

if ($_REQUEST["borrar"]=='ok'){

	$id_lista = $_REQUEST['id_lista'];
	$q = query("SELECT count(*) as cant FROM categoria_clientes WHERE id_lista = $id_lista");
	$rs = mysql_fetch_array($q);
	if ($rs['cant'] == 0){
		$sql = "DELETE FROM listas where id_lista = '" . $_REQUEST['id_lista'] . "'";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La lista '".$lista."' se elimino correctamente</font>";		
	}else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>No se pudo borrar la lista '".$lista."' debido a que hay tipos de clientes asociados a ella.</font>";
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
		return confirm("Estás seguro que queres agregar esta lista?");
}
function confirmarM(){
		return confirm("Estás seguro que queres modificar esta lista?");
}
function confirmarE(){
		return confirm("Estás seguro que queres eliminar esta lista?");
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

<p align="center" class="titulo"><strong>Listas de precios</strong></p>
<br>
<p class="error" align="center"><?=$msg?></p>
<table width="500" align="center" cellpadding="0" cellspacing="1">
	<tr height="30">
		<td width="6%" class="t">&nbsp;</td>
		<td width="57%" class="t" align="center">Listas</td>
		<td width="12%" class="t" align="center">Sigla</td>
		<td width="19%" class="t">&nbsp;</td>
		<td width="6%" class="t">&nbsp;</td>
	</tr>
	<form action="<?=$_SERVER['PHP_SELF']?>" name="agregar" method="post">
		<tr height="40">
			<td class="c2">&nbsp;</td>
			<td class="c2">&nbsp;&nbsp;<input name="lista" type="text" id="lista" size="40"></td>
			<td class="c2">&nbsp;&nbsp;<input name="sigla" type="text" id="sigla" size="3"></td>
			<td class="c2" align="center">&nbsp;&nbsp;&nbsp;
				<input type="image" src="images/b_insert.png" onClick="return confirmarA();" alt="Agregar la nueva lista">
				<input type="hidden" name="Agregar" value="ok">
			</td>
			<td class="c2">&nbsp;</td>
		</tr>
	</form>
	<tr height="1"><td colspan="5"></td></tr>
	<?
	$q = query("SELECT * FROM listas ORDER BY lista");
	if(mysql_num_rows($q)>0){
		$i = 1;
		while($rs = mysql_fetch_array($q)){
			$c = $flag ? "c1":"c2";
			$flag =! $flag;	
		?>
			<form name="lista<?= $i?>" action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<tr height="40">
				<td class="<?= $c?>">&nbsp;</td>
				<td class="<?= $c?>">&nbsp;&nbsp;<input name="lista"  value="<?=$rs['lista']?>"type="text" size="40"></td>
				<td class="<?= $c?>">&nbsp;&nbsp;<input name="sigla"  value="<?=$rs['sigla']?>"type="text" size="3"></td>
				<td class="<?= $c?>" align="center">
					<input type="image" src="images/b_save.png" onClick="return confirmarM();" alt="Modificar la lista <?= $rs['lista']?>">
					<input type="hidden" name="modificar" value="ok">&nbsp;
					<a href="<?= $_SERVER['PHP_SELF']?>?borrar=ok&id_lista=<?= $rs['id_lista']?>&lista=<?= $rs['lista']?>" onClick="return confirmarE();"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar la lista <?= $rs['lista']?>"></a>
					<input type="hidden" name="id_lista" value="<?=$rs['id_lista']?>">
				</td>
				<td class="<?= $c?>">&nbsp;</td>
			</tr>
			</form>
		<? 	
			$i++;
		}
	}
	?>
	<tr height="15"><td colspan="5" class="t"></td></tr>
</table>
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
