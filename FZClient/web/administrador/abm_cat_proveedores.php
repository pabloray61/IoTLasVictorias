<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$id_categoria = $_REQUEST["id_categoria"];
$categoria = $_REQUEST["categoria"];

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["guardar"] == "ok"){
	$d = "DELETE FROM categoria_proveedores WHERE id_categoria = $id_categoria";
	if($insertar == "ok") mysql_query($d, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$d."<br>");

	$reg = $_REQUEST["reg"];
	for($i = 0; $i < $reg; $i++){
		$id_proveedor = $_REQUEST['id_proveedor_'.$i];
		$sql =  "INSERT INTO categoria_proveedores VALUES ($id_categoria, $id_proveedor)";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql."<br>");
	}
	header ("location:abm_i_categorias.php");
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

<p align="center" class="titulo"><b>Porveedores para la categoria &#8220;<?= $categoria?>&#8221;</b></p>
<br>
<table width="300" align="center" cellpadding="0" cellspacing="1">
	<form name="lista<?= $i?>" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<tr height="50">
		<td width="25" class="t">&nbsp;</td>
		<td width="200" class="t">&nbsp;&nbsp;Proveedores</td>
		<td width="50" class="t" align="center"><input type="image" src="images/b_save.png"></td>
		<td width="25" class="t">&nbsp;</td>
	</tr>
	<tr height="1"><td></td></tr>
		<input type="hidden" name="guardar" value="ok">
		<input type="hidden" name="id_categoria" value="<?= $id_categoria?>">
		<input type="hidden" name="categoria" value="<?= $categoria?>">
		<?
		$q = query("SELECT * FROM proveedores ORDER BY empresa");
		if(mysql_num_rows($q)>0){
			$i = 0;
			while($rs = mysql_fetch_array($q)){
				$ck = "";
				$c = $flag ? "c1":"c2";
				$flag =! $flag;	
				$id_proveedor = $rs['id_proveedor'];
				$empresa = $rs['empresa'];
				$q2 = query("SELECT * FROM categoria_proveedores WHERE id_categoria = $id_categoria AND id_proveedor = $id_proveedor");
				if(mysql_num_rows($q2)>0) $ck = "CHECKED";
				?>
				<tr height="40">
					<td class="<?= $c?>">&nbsp;</td>
					<td class="<?= $c?>">&nbsp;&nbsp;<?= $empresa?></td>
					<td class="<?= $c?>" align="center">&nbsp;&nbsp;<input type="checkbox" name="id_proveedor_<?= $i?>" value="<?= $id_proveedor?>" <?= $ck?>></td>
					<td class="<?= $c?>">&nbsp;</td>
				</tr>
				<? 	
				$i++;
			}
		}
		?>
		<input type="hidden" name="reg" value="<?= $i?>">
	</form>
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
