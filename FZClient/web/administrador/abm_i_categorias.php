<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$categoria = $_REQUEST["categoria"];

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["Agregar"] == "Agregar" and $_REQUEST["categoria"] != ""){
	$q2 = query("SELECT * FROM i_categorias WHERE categoria = '$categoria'");
	$cant = mysql_num_rows($q2);
	if ($cant == 0){		
		$sql =  "INSERT INTO i_categorias VALUES (null,'$categoria')";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La categoria '".$categoria."' se agrego correctamente</font>";
	}
	else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>La categoria '".$categoria."' ya se encuentra cargada</font>";
	}
}
if ($_REQUEST['modificar'] == "Modificar"){
	$sql = "UPDATE i_categorias SET categoria= '$categoria' WHERE id_categoria = '" . $_REQUEST['id_categoria'] ."'";
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La categoria '".$categoria."' se modifico correctamente</font>";
}

if ($_REQUEST["borrar"]=='Borrar'){

	$id_categoria = $_REQUEST['id_categoria'];
	$q = query("SELECT count(*) as cant FROM insumos WHERE id_categoria = $id_categoria");
	$rs = mysql_fetch_array($q);
	if ($rs['cant'] == 0){
		$sql = "DELETE FROM i_categorias where id_categoria = '" . $_REQUEST['id_categoria'] . "'";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>La categoria '".$categoria."' se elimino correctamente</font>";		
	}else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>No se pudo borrar la categoria '".$categoria."' debido a que hay insumos asignados a ella.</font>";
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
		return confirm("Estás seguro que queres agregar esta categoria?");
}
function confirmarM(){
		return confirm("Estás seguro que queres modificar esta categoria?");
}
function confirmarE(){
		return confirm("Estás seguro que queres eliminar esta categoria?");
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

<p align="center" class="titulo"><strong>Categorias de Iinsumos</strong></p>
<br>
<p class="error" align="center"><?=$msg?></p>
<table width="500" align="center" cellpadding="0" cellspacing="1">
	<tr height="30">
		<td width="25" class="t">&nbsp;</td>
		<td width="250" class="t">&nbsp;&nbsp;Categorias</td>
		<td width="100" class="t">&nbsp;</td>
		<td width="25" class="t">&nbsp;</td>
	</tr>
	<form action="<?=$_SERVER['PHP_SELF']?>" name="agregar" method="post">
		<tr height="40">
			<td class="c2">&nbsp;</td>
			<td class="c2">&nbsp;&nbsp;<input name="categoria" type="text" id="categoria" size="50"></td>
			<td class="c2">&nbsp;&nbsp;&nbsp;
				<input type="image" src="images/b_insert.png" onClick="return confirmarA();" alt="Agregar la nueva categoria">
				<input type="hidden" name="Agregar" value="Agregar">
			</td>
			<td class="c2">&nbsp;</td>
		</tr>
	</form>
	<tr height="1"><td></td></tr>
	<?
	$q = query("SELECT * FROM i_categorias ORDER BY categoria");
	if(mysql_num_rows($q)>0){
		$i = 1;
		while($rs = mysql_fetch_array($q)){
			$c = $flag ? "c1":"c2";
			$flag =! $flag;	
		?>
			<form name="lista<?= $i?>" action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<tr height="40">
				<td class="<?= $c?>">&nbsp;</td>
				<td class="<?= $c?>">&nbsp;&nbsp;<input name="categoria"  value="<?=$rs['categoria']?>"type="text" size="50"></td>
				<td class="<?= $c?>">&nbsp;&nbsp;
					<a href="abm_cat_proveedores.php?id_categoria=<?= $rs['id_categoria']?>&categoria=<?=$rs['categoria']?>"><img src="images/b_proveedor.png" alt="Ver o modificar los proveedores del insumo <?=$rs['categoria']?>" border="0"></a>&nbsp;&nbsp;
					<input type="image" src="images/b_save.png" onClick="return confirmarM();" alt="Modificar la categoria <?= $rs['categoria']?>">
					<input type="hidden" name="modificar" value="Modificar">&nbsp;&nbsp;
					<a href="<?= $_SERVER['PHP_SELF']?>?borrar=Borrar&id_categoria=<?= $rs['id_categoria']?>&categoria=<?= $rs['categoria']?>" onClick="return confirmarE();"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar la categoria <?= $rs['categoria']?>"></a>
					<input type="hidden" name="id_categoria" value="<?=$rs['id_categoria']?>">
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
