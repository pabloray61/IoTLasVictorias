<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$ver = $_REQUEST['ver'];
if($ver == "") $ver = "listar";

$id_deposito = $_REQUEST['id_deposito'];
$deposito = $_REQUEST["deposito"];
$telefono = $_REQUEST["telefono"];
$direccion = $_REQUEST["direccion"];
$localidad = $_REQUEST["localidad"];
$cp = $_REQUEST["cp"];
$observaciones = $_REQUEST["observaciones"];


// ------- IMPRIMIR O INSERTAR ----------------
	$insertar = "ok";
	//$imprimir = "ok";
// -------------------------------------------
if ($_REQUEST["Agregar"] == "ok" and $_REQUEST["deposito"] != ""){
	$q2 = query("SELECT * FROM depositos WHERE deposito = '$deposito'");
	$cant = mysql_num_rows($q2);
	if ($cant == 0){		
		$sql =  "INSERT INTO depositos VALUES (null,'$deposito', '$telefono', '$direccion', '$localidad', '$cp', '$observaciones')";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo $sql;
	}
	else{
		$msg = "Ya existe un deposito con ese nombre.";
	}
}
if ($_REQUEST['Modificar'] == "ok"){
	$sql = "UPDATE depositos SET deposito= '$deposito', telefono='$telefono', direccion='$direccion', localidad='$localidad', cp='$cp', observaciones='$observaciones' WHERE id_deposito = '" . $_REQUEST['id_deposito'] ."'";
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo $sql;
}

if ($_REQUEST["Borrar"] == 'ok'){

	$id_deposito = $_REQUEST['id_deposito'];
	$q = query("SELECT count(*) as cant FROM stock WHERE id_deposito = $id_deposito");
	$rs = mysql_fetch_array($q);
	if ($rs['cant'] == 0){
		if($insertar == "ok") mysql_query("DELETE FROM depositos where id_deposito = '" . $_REQUEST['id_deposito'] . "'", $conn_id);
		if($imprimir == "ok") echo "DELETE FROM proximos where id = " . $_REQUEST['id'];
	}else{
		$msg="No se puede borrar el deposito debido a que hay stock asignados a el.";
	}
}

if ($_REQUEST['Cancelar']=='Cancelar'){
	$id_deposito="";
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

	
	<p align="center" class="titulo"><strong>Productos</strong></p>
	<br>
	<p class="error" align="center"><?=$msg?></p>
<?
if($ver != "listar" AND $ver != "historial"){
?>
	<form name="formu" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<table width="500" align="center" cellpadding="0" cellspacing="0" border="0">
			<?
			if($id_deposito > 0){
				$q = query("SELECT * FROM depositos WHERE id_deposito= ". $_REQUEST['id_deposito']);
				$rs = mysql_fetch_array($q);
				$deposito = $rs['deposito'];
				$telefono = $rs['telefono'];
				$direccion = $rs['direccion'];
				$localidad = $rs['localidad'];
				$cp = $rs['cp'];
				$observaciones = $rs['observaciones'];
				?>
					<tr height="30"><td colspan="4" class="t" align="center">Modificar el Deposito</td></tr>
				<?
			}else{
					$deposito = "";
					$telefono = "";
					$direccion = "";
					$localidad = "";
					$cp = "";
					$observaciones = "";
				?>
					<tr height="30"><td colspan="4" class="t" align="center">Agregar un Deposito</td></tr>
				<?
			}
			?>
			<tr height="30">
				<td class="c1" width="5%">&nbsp;</td>
				<td class="c1" width="20%">Deposito</td>
				<td class="c1" width="70%"><input name="deposito" type="text" id="deposito" value="<?=$deposito?>"></td>
				<td class="c1" width="5%">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2">Telefono</td>
				<td class="c2"><input name="telefono" type="text" id="telefono"  value="<?=$telefono?>"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1">Direccion</td>
				<td class="c1"><input type="text" name="direccion"  value="<?=$direccion?>"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2">Localidad</td>
				<td class="c2"><input name="localidad" type="text" id="localidad" value="<?=$localidad?>"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1">CP</td>
				<td class="c1"><input type="text" name="cp" value="<?=$cp?>" size="4"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="160">
				<td class="c2">&nbsp;</td>
				<td class="c2">Observaciones</td>
				<td class="c2"><textarea name="observaciones" cols="45" rows="9"><?=$observaciones?></textarea></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<? if ($id_deposito > 0){?>
				<tr height="50">
					<td class="t" colspan="4" align="center">
						<input type="hidden" value="<?=$rs['id_deposito']?>" name="id_deposito">
						<input type="image" src="images/b_save.png" onClick="return confirm('Estás seguro que queres modificar el deposito <?= $rs['deposito']?>?');" title="Guardar las modificaciones">
						<input type="hidden" name="Modificar" value="ok">&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="<?= $_SERVER['PHP_SELF']?>?Cancelar=Cancelar" onClick="return confirm('Estás seguro que queres volver sin guardar los cambios?');"><img src="images/b_back.png" width="30" height="30" border="0" alt="Volver al listado"></a>&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
				<?
			}else{?> 
				<tr height="50">
					<td class="t" colspan="4" align="center">
						<input type="image" src="images/b_insert.png" onClick="return confirm('Estás seguro que queres agregar el deposito?');" title="Agregar el deposito">
						<input type="hidden" name="Agregar" value="ok">&nbsp;&nbsp;
						<a href="<?= $_SERVER['PHP_SELF']?>?Cancelar=Cancelar" onClick="return confirm('Estás seguro que queres volver sin agregar el deposito?');"><img src="images/b_back.png" width="30" height="30" border="0" alt="Volver al listado"></a>&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
			<? }?> 
		</table>
	</form>

<? 
}
elseif($ver == "historial"){
	$q0 = query("SELECT * FROM depositos WHERE id_deposito = $id_deposito");
	$rs0 = mysql_fetch_array($q0);
	$deposito = $rs0['deposito'];
	$q = query("
				SELECT 'Produccion' AS accion, producto, linea, id_deposito, fecha, cantidad, costo FROM produccion p
				INNER JOIN productos pr ON pr.id_producto = p.id_producto
				INNER JOIN lineas l ON l.id_linea = pr.id_linea
				WHERE id_deposito = $id_deposito
					UNION 
				SELECT 'Trans. Out' AS accion, producto, linea, id_deposito_out, fecha, cantidad, costo FROM transferencia t
				INNER JOIN productos pr ON pr.id_producto = t.id_producto
				INNER JOIN lineas l ON l.id_linea = pr.id_linea
				WHERE id_deposito_out = $id_deposito
					UNION 
				SELECT 'Trans. In' AS accion, producto, linea, id_deposito_out, fecha, cantidad, costo FROM transferencia t
				INNER JOIN productos pr ON pr.id_producto = t.id_producto
				INNER JOIN lineas l ON l.id_linea = pr.id_linea
				WHERE id_deposito_in = $id_deposito
					UNION 
				SELECT 'Caj. abiertas' AS accion, producto, linea, id_deposito, fecha, cantidad_c, 0 FROM abrir a
				INNER JOIN productos pr ON pr.id_producto = a.id_producto_c
				INNER JOIN lineas l ON l.id_linea = pr.id_linea
				WHERE id_deposito = $id_deposito
					UNION
				SELECT 'Bot. creadas' AS accion, producto, linea, id_deposito, fecha, cantidad_b, 0 FROM abrir a
				INNER JOIN productos pr ON pr.id_producto = a.id_producto_b
				INNER JOIN lineas l ON l.id_linea = pr.id_linea
				WHERE id_deposito = $id_deposito
				ORDER BY fecha DESC
			");
	?>
	<table width="580" align="center" cellpadding="0" cellspacing="0">		
	  <tr><td colspan="6" align="right"><a href="abm_depositos.php">volver</a>&nbsp;&nbsp;</td></tr>
	  <tr><td colspan="6">&nbsp;</td></tr>
	  <tr><td colspan="6" class="titulo" align="center"><?= $deposito?></td></tr>
	  <tr><td colspan="6">&nbsp;</td></tr>
	  <tr><td colspan="6">&nbsp;</td></tr>
	  <tr>
		<td width="15%" class="encabezado">Accion</td>
		<td width="22%" class="encabezado">Linea</td>
		<td width="30%" class="encabezado">Producto</td>
		<td width="13%" class="encabezado" align="center">Fecha</td>
		<td width="10%" class="encabezado" align="center">Cant</td>
		<td width="10%" class="encabezado" align="right">Costo</td>
	  </tr>	
	<?
	while($rs = mysql_fetch_array($q)){
		$fecha = $rs['fecha'];
		list($ano, $mes, $dia) = split( '[/.-]', $fecha);
			$fecha = $dia."-".$mes."-".$ano;
		?>
		  <tr height="20">
			<td class="data"><?=$rs['accion']?></td>
			<td class="data"><?= substr($rs['linea'],0, 18)?></td>
			<td class="data"><?= substr($rs['producto'],0, 27)?></td>
			<td class="data" align="center"><?= $fecha?></td>
			<td class="data" align="center"><?= $rs['cantidad']?></td>
			<td class="data" align="right">$&nbsp;<?= number_format($rs['costo'], 2, ',', '.')?></td>
		  </tr>	
		<?		
	}
	?>
	</table>
	
	
<?
}
else{
?>


<table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr><td colspan="6" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?ver=insert"><img src="images/b_insert_new.png" border="0" alt="Insertar una nueva presentacion"></a></td></tr>
	<tr height="3"><td colspan="6"></td></tr>
	<tr height="30">
		<td width="2%" class="t">&nbsp;</td>
		<td width="37%" class="t">Nombre</td>
		<td width="15%" class="t" align="center">Telefono</td>
		<td width="30%" class="t">Direccion</td>
		<td width="14%" class="t">&nbsp;</td>
		<td width="2%" class="t">&nbsp;</td>
	</tr>
<?
$sql = "SELECT * FROM depositos";
$q = query($sql);
	while($rs = mysql_fetch_array($q)){
		$id_deposito = $rs['id_deposito'];
		$c = $flag ? "c1":"c2";
		$flag =! $flag;
		?>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<input type="hidden" name="id_deposito" value="<?=$rs['id_deposito']?>">
			<tr height="40">
				<td class="<?= $c?>">&nbsp;</td>
				<td class="<?= $c?>"><?=$rs['deposito']?></td>
				<td class="<?= $c?>" align="center"><?=$rs['telefono']?></td>
				<td class="<?= $c?>"><?=substr($rs['direccion'],0,20)?></td>
				<td class="<?= $c?>" align="center">
					<a href="<?= $_SERVER['PHP_SELF']?>?ver=detalle&id_deposito=<?= $id_deposito?>"><img src="images/b_insert.png" border="0"></a>&nbsp;&nbsp;&nbsp;
					<a href="<?= $_SERVER['PHP_SELF']?>?ver=historial"><img src="images/historial.png" border="0"></a>&nbsp;&nbsp;&nbsp;
					<a href="<?= $_SERVER['PHP_SELF']?>?Borrar=ok&id_deposito=<?= $id_deposito?>&deposito=<?=$rs['deposito']?>" onClick="return confirm('Estás seguro que queres eliminar al deposito <?= $rs['deposito']?>?');"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar el deposito <?= $rs['deposito']?>"></a>
				</td>
				<td class="<?= $c?>">&nbsp;</td>
			</tr>
		</form>
		<?
			$i += 1;
		}
	?>
	<tr height="30"><td class="t" colspan="6">&nbsp;&nbsp;&nbsp;Total de Depositos: <?= $i?></td></tr>
</table>
	
<?
}
?>


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
