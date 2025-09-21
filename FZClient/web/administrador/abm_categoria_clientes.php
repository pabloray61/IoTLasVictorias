<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST["Agregar"]=="Agregar" and $_REQUEST["categoria"]!=""){
	$qck = query("SELECT * FROM categoria_clientes WHERE categoria = '".$_REQUEST["categoria"]."' OR sigla = '".$_REQUEST['sigla']."'");
	if(mysql_num_rows($qck) == 0){
		$sql =  "INSERT INTO categoria_clientes VALUES(null,'".$_REQUEST["categoria"]."', '".$_REQUEST['sigla']."',".$_REQUEST['id_lista'].")";
			if($insertar == "ok") mysql_query($sql, $conn_id);
			if($imprimir == "ok") echo("SQL: ".$sql);
	}else{
		$msg = "La categoria que esta queriendo agregar ya existe o repite la sigla de alguna categoria ya cargada.<br> Revise los datos y carguelos nuevamente.";
	}
}
if ($_REQUEST['modificar']=="Modificar"){
	$qck = query("SELECT * FROM categoria_clientes WHERE categoria = '".$_REQUEST["categoria"]."' OR sigla = '".$_REQUEST['sigla']."'");
	if(mysql_num_rows($qck) == 0){
		$sql= "UPDATE categoria_clientes SET categoria = '". $_REQUEST['categoria'] ."', sigla= '".$_REQUEST['sigla']."', id_lista = '". $_REQUEST['id_lista'] ."' WHERE id_categoria = " . $_REQUEST['id_categoria'];
			if($insertar == "ok") mysql_query($sql, $conn_id);
			if($imprimir == "ok") echo("SQL: ".$sql);
		$id_categoria = ""; //oculta el form abm
	}else{
		$msg = "La categoria que esta queriendo modificar ya existe o repite la sigla de alguna categoria ya cargada.<br> Revise los datos y carguelos nuevamente.";
	}
}
if ($_REQUEST['ac']== 'borrar'){
	$sql= "DELETE FROM categoria_clientes WHERE id_categoria= " . $_REQUEST['id_categoria'];
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo("SQL: ".$sql);
	$id_cliente = ""; //oculta el form abm
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
<p align="center" class="titulo"><strong>ABM Categorias</strong></p>
<br>
<p class="error" align="center"><?=$msg?></p>
<table width="600" align="center" cellpadding="0" cellspacing="1">
	<tr height="30">
		<td width="5%" class="t">&nbsp;</td>
		<td width="35%" class="t"><div align="center">Categoria</div></td>
		<td width="10%" class="t"><div align="center">Sigla</div></td>
		<td width="30%" class="t"><div align="center">Lista de precio Standar</div></td>
		<td width="15%" class="t">&nbsp;</td>
		<td width="5%" class="t">&nbsp;</td>
	</tr>
	<form action="<?=$_SERVER['PHP_SELF']?>" name="agregar" method="post">
		<tr height="40">
			<td class="c2">&nbsp;</td>
			<td class="c2" align="center"><input name="categoria" type="text" id="categoria" size="30"></td>
			<td class="c2" align="center"><input name="sigla" type="text" id="sigla" size="4" style="text-align:center;"></td>
			<td class="c2">&nbsp;
				<select name="id_lista">
					<option value="0">Listas</option>
					<? 
					$sql2="SELECT * FROM listas ORDER BY lista";
					$q2=query($sql2);
					while($rs2=mysql_fetch_array($q2)){?>
						<option value="<?=$rs2['id_lista']?>" <? if($rs2['id_lista']==$rs['id_lista']){echo " SELECTED";} ?>><?=$rs2['lista']?></option>
					<? }?>
			  </select>
			</td>
			<td class="c2">&nbsp;&nbsp;&nbsp;
				<input type="image" src="images/b_insert.png" onClick="return confirmarA();">
				<input type="hidden" name="Agregar" value="Agregar">
			</td>
			<td class="c2">&nbsp;</td>
		</tr>
	</form>
	<tr height="1"><td></td></tr>
	<?
	$q = query("SELECT * FROM categoria_clientes");
	$i = 1;
	while($rs=mysql_fetch_array($q)){
		$c = $flag ? "c1":"c2";
		$flag =! $flag;	
	?>
		<form name="lista<?= $i?>" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<tr height="40">
			<td class="<?= $c?>">&nbsp;</td>
			<td class="<?= $c?>" align="center"><input name="categoria"  value="<?=$rs['categoria']?>"type="text"  size="30"></td>
			<td class="<?= $c?>" align="center"><input name="sigla"  value="<?=$rs['sigla']?>"type="text"  size="4" style="text-align:center;"></td>
			<td class="<?= $c?>">&nbsp;
				<select name="id_lista">
					<option value="0">Seleccione una lista</option>
					<? $sql2="SELECT * FROM listas ORDER BY lista";
						$q2=query($sql2);
						while($rs2=mysql_fetch_array($q2)){?>
						<option value="<?=$rs2['id_lista']?>" <? if($rs2['id_lista']==$rs['id_lista']){echo " SELECTED";} ?> > <?=$rs2['lista']?></option>
					<?	}?>
				</select>
			</td>
			<td class="<?= $c?>">&nbsp;&nbsp;
				<input type="image" src="images/b_save.png" onClick="return confirmarM();">
				<input type="hidden" name="modificar" value="Modificar">&nbsp;
				<a href="<?= $_SERVER['PHP_SELF']?>?ac=borrar&id_categoria=<?= $rs['id_categoria']?>" onClick="return confirmarE();"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar la categoria <?= $rs['categoria']?>"></a>
				<input type="hidden" name="id_categoria" value="<?=$rs['id_categoria']?>">
			</td>
			<td class="<?= $c?>">&nbsp;</td>
		</tr>
		</form>
	<? 	
		$i++;
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
