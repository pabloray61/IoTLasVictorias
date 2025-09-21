<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$grupo = $_REQUEST["grupo"];
$detalle = $_REQUEST['detalle'];

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["Agregar"] == "Agregar" and $_REQUEST["grupo"] != ""){
	$q2 = query("SELECT * FROM grupos WHERE grupo = '$grupo'");
	$cant = mysql_num_rows($q2);
	if ($cant == 0){		
		$sql =  "INSERT INTO grupos VALUES (null,'$grupo', '$detalle')";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
	}
	else{
		$msg = "Ya existe un grupo con ese nombre.";
	}
}
if ($_REQUEST['modificar'] == "Modificar"){
	$sql = "UPDATE grupos SET grupo= '$grupo', detalle='$detalle' WHERE id_grupo = '" . $_REQUEST['id_grupo'] ."'";
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
}

if ($_REQUEST["borrar"]=='Borrar'){

	$id_grupo = $_REQUEST['id_grupo'];
	$q = query("SELECT count(*) as cant FROM clientes WHERE id_grupo = $id_grupo");
	$rs = mysql_fetch_array($q);
	if ($rs['cant'] == 0){
		$sql = "DELETE FROM grupos where id_grupo = '" . $_REQUEST['id_grupo'] . "'";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
	}else{
		$msg="No se puede borrar el grupo debido a que hay clientes asignados a el.";
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
		return confirm("Estás seguro que queres agregar este grupo?");
}
function confirmarM(){
		return confirm("Estás seguro que queres modificar este grupo?");
}
function confirmarE(){
		return confirm("Estás seguro que queres eliminar este grupo?");
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

<p align="center" class="titulo"><strong>ABM Grupos</strong></p>
<br>
<p class="error" align="center"><?=$msg?></p>
<table width="850" align="center" cellpadding="0" cellspacing="1">
	<tr height="30">
		<td width="2%" class="t">&nbsp;</td>
		<td width="38%" class="t"><div align="center">Grupo</div></td>
        <td width="48%" class="t"><div align="center">Detalle</div></td>
		<td width="10%" class="t">&nbsp;</td>
		<td width="2%" class="t">&nbsp;</td>
	</tr>
	<form action="<?=$_SERVER['PHP_SELF']?>" name="agregar" method="post">
		<tr height="70">
			<td class="c2">&nbsp;</td>
			<td class="c2">&nbsp;&nbsp;<input name="grupo" type="text" id="grupo" size="50"></td>
            <td class="c2">&nbsp;&nbsp;<textarea name="detalle" type="text" id="detalle" cols="58" rows="3"></textarea></td>
			<td class="c2" align="center">
				<input type="image" src="images/b_insert.png" onClick="return confirmarA();">
				<input type="hidden" name="Agregar" value="Agregar">
			</td>
			<td class="c2">&nbsp;</td>
		</tr>
	</form>
	<tr height="1"><td></td></tr>
	<?
	$q = query("SELECT * FROM grupos ORDER BY grupo");
	if(mysql_num_rows($q)>0){
		$i = 1;
		while($rs = mysql_fetch_array($q)){
			$c = $flag ? "c1":"c2";
			$flag =! $flag;	
		?>
			<form name="lista<?= $i?>" action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<tr height="70">
				<td class="<?= $c?>">&nbsp;</td>
				<td class="<?= $c?>">&nbsp;&nbsp;<input name="grupo"  value="<?=$rs['grupo']?>"type="text" size="50"></td>
                <td class="<?= $c?>">&nbsp;&nbsp;<textarea name="detalle" type="text" id="detalle" cols="58" rows="3"><?=$rs['detalle']?></textarea></td>
				<td class="<?= $c?>" align="center">
					<input type="image" src="images/b_save.png" onClick="return confirmarM();">
					<input type="hidden" name="modificar" value="Modificar">&nbsp;
					<a href="<?= $_SERVER['PHP_SELF']?>?borrar=Borrar&id_grupo=<?= $rs['id_grupo']?>" onClick="return confirmarE();"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar el grupo <?= $rs['grupo']?>"></a>
					<input type="hidden" name="id_grupo" value="<?=$rs['id_grupo']?>">
				</td>
				<td class="<?= $c?>">&nbsp;</td>
			</tr>
			</form>
		<? 	
			$i++;
		}
	}
	?>
	<tr height="15"><td colspan="6" class="t"></td></tr>
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
