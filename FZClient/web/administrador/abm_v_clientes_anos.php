<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];
$id_producto = $_REQUEST['id_producto'];
$id_categoria = $_REQUEST['id_categoria'];
$id_v = $_REQUEST['id_v'];
$id_grupo = $_REQUEST['id_grupo'];

if($mes == "" && $ano == "" && $id_producto == "" && $id_categoria == "" && $id_v == "") $ano = date("Y");
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

<p align="center" class="titulo">Ventas por Clientes / Años (Cajas)</p>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="formu">
	<table align="center" width="200" cellspacing="2" cellpadding="2">
		<tr>
			<td class="encabezado">Clientes</td>
			<td>
                <select name="id_categoria" onChange="javascript:formu.submit();">
                    <option>Todos</option>
                      <?
                      $q = query("SELECT * FROM categoria_clientes");
                      while ($rs = mysql_fetch_array($q)){
                      ?>
                        <option value="<?=$rs['id_categoria']?>" <? if ($_REQUEST['id_categoria'] == $rs['id_categoria']){echo " SELECTED";} ?>><?=$rs['categoria']?>	</option>
                      <? }?>	
                </select>
			</td>
		</tr>
		<? if($_SESSION['admin']=="ok"){?>
			<tr>
				<td class="encabezado">Vendedor</td>
				<td>
					<select name="id_v" onChange="javascript:formu.submit();">
						<option>Todos</option>
						<?
						$q = query("SELECT * FROM vendedores ORDER BY nombre");
						while($rs=mysql_fetch_array($q)){
						?>
						<option value="<?=$rs['id_vendedor']?>" <? if ($_REQUEST['id_v']==$rs['id_vendedor']){echo " SELECTED";} ?>><?=$rs['nombre']?></option>
						<? }?>
					</select>
				</td>
			</tr>
		<? }?>
        <tr>
			<td class="encabezado">Grupo</td>
			<td>
            <? $q = query("SELECT * FROM grupos ORDER BY grupo");?>
			<select name="id_grupo" onChange="javascript:formu.submit();">
				<option>Todos</option>
				  <? while ($rs = mysql_fetch_array($q)){?>
					<option value="<?=$rs['id_grupo']?>" <? if ($_REQUEST['id_grupo'] == $rs['id_grupo']){echo " SELECTED";} ?>><?=$rs['grupo']?></option>
				  <? }?>	
			</select>
			</td>
		</tr>
	</table>
</form>
<br>
<?
$where = "";
if($_SESSION['admin']!="ok"){
	$where="WHERE c.id_vendedor=" . $_SESSION['id_vendedor'] . "  and";
} else{
	$where =" WHERE";
}
if($id_categoria > 0){ $where = $where . " c.id_categoria=" . $id_categoria. "   and";}
if($id_v > 0){ $where = $where . " c.id_vendedor=" . $id_v. "   and";}
if($id_grupo > 0){ $where = $where . " g.id_grupo=" . $id_grupo. "   and";}

$where = substr($where,0,strlen($where)-5);

$sql = "SELECT c.id_cliente, c.apellido, c.nombre, vc.nombre AS vendedor, vc.sigla AS sv, cc.categoria, cc.sigla AS sc FROM ventas v
		INNER JOIN ventas_detalle vd ON vd.id_venta = v.id_venta
		INNER JOIN clientes c ON c.id_cliente = v.id_cliente
		INNER JOIN vendedores vc ON vc.id_vendedor = c.id_vendedor
		INNER JOIN categoria_clientes cc ON cc.id_categoria = c.id_categoria
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		$where GROUP BY v.id_cliente ORDER BY c.apellido, c.nombre";
$q = query($sql);
$cajas_T = array();

$qa = 5; // CANT DE ANOS

if(mysql_num_rows($q)>0){
	?>
	<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr class="t" height="30">
				<td class="t" width="1%">&nbsp;</td>
				<td class="t" width="4%">CAT</td>
				<td class="t" width="4%">VEN</td>
				<td class="t" width="24%">Cliente</td>
				<? for($i = (date("Y")- $qa); $i <= date("Y"); $i++){?>
					<td class="t" width="6%" align="center"><?= $i?></td>
				<? }?>
				<td class="t" width="1%">&nbsp;</td>
			</tr>
		</thead>
		  <?			
			while($rs = mysql_fetch_array($q)){
				$id_cliente = $rs['id_cliente'];
				$nombre = $rs['apellido'];
				$n = $rs['nombre'];
				if($n != "") $nombre = $nombre.", ".$n;
				$vendedor = $rs['vendedor'];
				$sv = $rs['sv'];
				$categoria = $rs['categoria'];
				$sc = $rs['sc'];
				$reg += 1;
				$c = $flag ? "c1":"c2";
				$flag = !$flag;
				?>
				<tr height="25">
					<td class="<?= $c?>">&nbsp;</td>
					<td class="<?= $c?>" title="<?= $categoria?>"><?= $sc?></td>
					<td class="<?= $c?>" title="<?= $vendedor?>"><?= $sv?></td>
					<td class="<?= $c?>" style="border-right-style:solid; border-right-color:#333333;"><?= $nombre?></td>
						<?
						$sql2 = "SELECT ";
						for($a = (date("Y")- $qa); $a <= date("Y"); $a++){
							$sql2 .= "SUM( CASE WHEN unidades > 1 AND regalo != 1 AND YEAR(fecha) = '$a' THEN vd.cant ELSE 0 END ) AS c$a, ";
						}
						$sql2 = substr($sql2, 0, (strlen($sql2)-2));
						$sql2 .= " FROM ventas v 
								INNER JOIN clientes c on v.id_cliente = c.id_cliente
								INNER JOIN ventas_detalle vd on vd.id_venta = v.id_venta
								INNER JOIN productos p ON p.id_producto = vd.id_producto
								INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
								WHERE v.id_cliente = $id_cliente";
						//echo($sql2."<br>");
						$q2 = query($sql2);
						$rs2 = mysql_fetch_array($q2);
						for($a = (date("Y")- $qa); $a <= date("Y"); $a++){
							$cajas = $rs2['c'.$a];
							$cajas_T[$a] = $cajas_T[$a] + $cajas;
						?>
							<td class="<?= $c?>" align="center" title="<?= $nombre?> - Año <?= $a?>"><?= $cajas?></td>
						<? }?>
					<td class="<?= $c?>">&nbsp;</td>
				</tr>
				<? if($reg % 50 == 0){?>
					<tr class="t" height="30">
						<td class="t" width="1%">&nbsp;</td>
						<td class="t" width="4%">CAT</td>
						<td class="t" width="4%">VEN</td>
						<td class="t" width="24%">Cliente</td>
						<? for($i = (date("Y")- $qa); $i <= date("Y"); $i++){?>
							<td class="t" width="6%" align="center"><?= $i?></td>
						<? }?>
						<td class="t" width="1%">&nbsp;</td>
					</tr>
				<? }?>
			<? } // CIERRO EL WHILE Q?>
		<tr height="30">
			<td class="t" colspan="3">&nbsp;&nbsp;&nbsp;Total</td>
			<td class="t"><?= $reg?>&nbsp;registros</td>
			<? for($i = (date("Y")- $qa); $i <= date("Y"); $i++){?>
				<td align="center" class="t"><?= $cajas_T[$i]?></td>
			<? }?>
			<td class="t">&nbsp;</td>
		</tr>
	</table>
<?
}else{
	echo("<p class='titulo' align='center'>No se ha encontrado ningun registro</p>");
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
